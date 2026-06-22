<?php

class Request extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->uploadTypes = array(
            'doc'    => ['allowed_types' => 'pdf|docx|doc'],
            'all'    => ['allowed_types' => '*'],
            'img'    => ['allowed_types' => 'jpg|jpeg|png|jpg'],
            'html'   => ['allowed_types' => 'html'],
            'custom' => ['allowed_types' => 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|ppt|pptx']
        );
    }

    function id($id)
    {
        return array('md5(id)' => $id);
    }

    function encKey($key)
    {
        return "md5($key)";
    }

    function acak($text)
    {
        return md5($text);
    }

    function cekPerubahan()
    {
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function flash()
    {
        if ($this->session->flashdata('warning')) {
            echo '<div class="alert alert-warning">';
            echo $this->session->flashdata('warning');
            echo '</div>';
        }

        if ($this->session->flashdata('success')) {
            echo '<div class="alert alert-success">';
            echo $this->session->flashdata('success');
            echo '</div>';
        }

        if ($this->session->flashdata('error')) {
            echo '<div class="alert alert-danger">';
            echo $this->session->flashdata('error');
            echo '</div>';
        }
    }


    function print($array, $clear = true, $stop = true)
    {
        if ($clear == true) {
            ob_clean();
            echo "<pre>";
            echo print_r($array);
            echo "</pre>";
            exit(0);
        } else {
            echo "<pre>";
            echo print_r($array);
            echo "</pre>";
            if ($stop == true) {
                exit(0);
            }
        }
    }

    function session()
    {
        $this->print($_SESSION);
    }

    function json($array)
    {
        echo "<pre>";
        echo json_encode($array);
        echo "</pre>";
    }

    function query()
    {
        echo $this->db->last_query();
    }

    function input($input)
    {
        return htmlspecialchars(ltrim(rtrim($_POST[$input])));
    }

    function all($guarded = null)
    {
        $request = $_POST;
        foreach ($request as $key => $value) {
            $result[$key] = $this->input($key);
        }
        if ($guarded != null) {
            foreach ($guarded as $guard_ => $value) {
                if ($value == false) {
                    unset($request[$guard_]);
                } else {
                    unset($request[$guard_]);
                    $request[$guard_] = $value;
                }
            }
        }
        return $request;
    }


    function upload($data)
    {
        if (!file_exists($data['path'])) {
            mkdir($data['path'], 0777, true);
        }


        $maxSize = isset($data['max_size']) ? $data['max_size'] : 10000;


        $config = array(
            'upload_max_filesize' => $maxSize,  // Maksimal ukuran file
            'upload_path' => $data['path'],     // Path tempat file akan disimpan
            'encrypt_name' => $data['encrypt'], // Enkripsi nama file
            'max_size' => $maxSize,             // Ukuran maksimal file
        );

        // Konfigurasi tambahan jika ada parameter 'square'
        if (isset($data['square']) && $data['square']) {
            $squareCrop = true;
        } else {
            $squareCrop = false;
        }

        $config = array_merge($config, $this->uploadTypes[$data['type']]);

        // Load library upload dengan konfigurasi
        $this->load->library('upload', $config);

        // Lakukan proses upload
        $uploading = $this->upload->do_upload($data['file']) ? true : false;

        if (!$uploading) {
            return array(
                'message' => 'error',
                'data' => $this->upload->display_errors()
            );
        } else {
            // Ambil data file yang di-upload
            $upload_data = $this->upload->data();

            // Jika ada pengaturan square (crop to 1000x1000), lakukan crop
            if ($squareCrop) {
                $imageWidth = $upload_data['image_width'];
                $imageHeight = $upload_data['image_height'];

                // Tentukan ukuran dan posisi crop
                $cropSize = 2000;
                $x_axis = ($imageWidth / 2) - ($cropSize / 2); // Crop dari tengah-tengah
                $y_axis = ($imageHeight / 2) - ($cropSize / 2);

                $cropConfig['image_library'] = 'gd2';
                $cropConfig['source_image'] = $upload_data['full_path'];  // Path lengkap gambar yang di-upload
                $cropConfig['new_image'] = $upload_data['full_path'];     // Replace file yang ada
                $cropConfig['maintain_ratio'] = FALSE;  // Memaksa gambar menjadi 1000x1000 (tanpa menjaga rasio)
                $cropConfig['width'] = $cropSize;
                $cropConfig['height'] = $cropSize;
                $cropConfig['x_axis'] = $x_axis;  // Koordinat X untuk mulai crop
                $cropConfig['y_axis'] = $y_axis;  // Koordinat Y untuk mulai crop
                $cropConfig['quality'] = '90%';  // Kualitas gambar setelah crop

                // Load library image_lib untuk crop gambar
                $this->load->library('image_lib', $cropConfig);
                $this->image_lib->initialize($cropConfig);

                // Lakukan crop
                if (!$this->image_lib->crop()) {
                    return array(
                        'message' => 'error',
                        'data' => $this->image_lib->display_errors()
                    );
                }

                // Bersihkan konfigurasi library setelah digunakan
                $this->image_lib->clear();
            }

            // Return success dengan data upload
            return array(
                'message' => 'success',
                'data' => $upload_data
            );
        }
    }

    function upload_form($data)
    {

        $encrypt = (isset($data['encrypt']) == true) ? true : false;
        $fileName = (isset($data['fileName']) != '') ? $data['fileName'] : null;
        $customInput = (isset($data['customInput']) != '') ? $data['customInput'] : null;
        $maxSize = isset($data['max_size']) ? $data['max_size'] : 10000;

        if ($fileName) {
            $config = array(
                'upload_path' => './uploads/' . $data['path'],
                'file_name' => $data['fileName'],
                'max_size' => $maxSize
            );
        } else {
            $config = array(
                'upload_path' => './uploads/' . $data['path'],
                'encrypt_name' => $encrypt,
                'max_size' => $maxSize
            );
        }

        $config = array_merge($config, $this->uploadTypes[$data['type']]);
        $this->load->library('upload', $config);
        $uploading = $this->upload->do_upload($data['file']) ? true : false;
        if (!$uploading) {
            return $data_ = $this->all($customInput);
        } else {
            $data_ = $this->all($customInput);
            $upload_data = $this->upload->data();
            $result = array_merge($data_, [$data['file'] => $upload_data['file_name']]);
            // print_r($result);
            return $result;
        }
    }

    function upload_form_multi($data)
    {
        $fileName = [];
        // $this->print($data);
        $countfiles = count($_FILES[$data['file']]['name']);
        $maxSize = isset($data['max_size']) ? $data['max_size'] : 10000;
        $success = 0;

        if ($data['encrypt'] == true) {
            $config_ = array(
                'upload_path' => './uploads/' . $data['path'],
                'encrypt_name' => true,
                'max_size' => $maxSize
            );
        } else {
            $config_ = array(
                'upload_path' => './uploads/' . $data['path'],
                'encrypt_name' => false,
                'max_size' => $maxSize
            );
        }

        // echo $fileNameNa;

        $config = array_merge($config_, $this->uploadTypes[$data['type']]);

        $this->load->library('upload', $config);

        for ($i = 0; $i < $countfiles; $i++) {
            if (!empty($_FILES[$data['file']]['name'][$i])) {
                // echo $_FILES[$data['file']]['name'][$i];
                $fileNameNa = str_replace(["'", "`", ";", "^"], "", $_FILES[$data['file']]['name'][$i]);

                $_FILES['file']['name'] = $fileNameNa;
                $_FILES['file']['type'] = $_FILES[$data['file']]['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES[$data['file']]['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES[$data['file']]['error'][$i];
                $_FILES['file']['size'] = $_FILES[$data['file']]['size'][$i];

                $config['file_name'] = time() . "-" . $fileNameNa;

                $this->upload->initialize($config);

                // File upload
                $uploading = $this->upload->do_upload('file') ? true : false;

                if ($uploading) {
                    // Get data about the file
                    $success++;
                    $uploadData = $this->upload->data();
                    $fileName[] = $uploadData['file_name'];
                    $oriFile[] = $fileNameNa;
                } else {
                    return $this->upload->display_errors();
                }
            }
        }

        $fileNaGan = [];
        foreach ($fileName as $key) {
            $fileNaGan[] = $key;
        }

        $fileOriNaGan = [];
        foreach ($oriFile as $key) {
            $fileOriNaGan[] = $key;
        }

        // $fileNaGan = substr($fileNaGan, 0, strlen($fileNaGan) - 1);
        // $fileOriNaGan = substr($fileOriNaGan, 0, strlen($fileOriNaGan) - 1);
        // print_r($fileName);
        $custom = isset($data['customInput']) ? $data['customInput'] : null;
        return [
            'total' => $countfiles,
            'success' => $success,
            // 'data' => $this->all($custom),
            'file' => [
                'lampiran' => $fileNaGan,
                'oriFile'  => $fileOriNaGan
            ]
        ];

        // $fileNaGan = "";
        // foreach ($fileName as $key) {
        //     $fileNaGan .= "$key,";
        // }

        // $fileOriNaGan = "";
        // foreach ($oriFile as $key) {
        //     $fileOriNaGan .= "$key,";
        // }

        // $fileNaGan = substr($fileNaGan, 0, strlen($fileNaGan) - 1);
        // $fileOriNaGan = substr($fileOriNaGan, 0, strlen($fileOriNaGan) - 1);
        // // print_r($fileName);
        // $custom = isset($data['customInput']) ? $data['customInput'] : null;
        // return [
        //     'total' => $countfiles,
        //     'success' => $success,
        //     // 'data' => $this->all($custom),
        //     'file' => [
        //         'lampiran' => $fileNaGan,
        //         'oriFile'  => $fileOriNaGan
        //     ]
        // ];
    }


    function dateIndo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public function waktuIndo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode(' ', $tanggal);
        $tanggalPecah = explode('-', $pecahkan[0]);
        $waktuPecah = explode(':', $pecahkan[1]);

        return $tanggalPecah[2] . ' ' . $bulan[(int)$tanggalPecah[1]] . ' ' . $tanggalPecah[0] . ' ' . $waktuPecah[0] . ':' . $waktuPecah[1] . ':' . $waktuPecah[2];
    }

    function getBulan($bul)
    {
        // $bul = date('n');

        switch ($bul) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Febuari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        return $bulan;
    }

    public function getHari($hari)
    {
        // $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "";
                break;
        }

        return $hari_ini;
    }

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }


    private $key = "bhisa_tessoal";

    function enc_string($string)
    {
        $result = '';
        $string_length = strlen($string);
        $key_length = strlen($this->key);

        for ($i = 0; $i < $string_length; $i++) {
            $key_char = $this->key[$i % $key_length];
            $result .= $string[$i] ^ $key_char;
        }

        return base64_encode($result);
    }

    function dec_string($string)
    {
        $string = base64_decode($string);
        if ($string === false) return false;

        $result = '';
        $string_length = strlen($string);
        $key_length = strlen($this->key);

        for ($i = 0; $i < $string_length; $i++) {
            $key_char = $this->key[$i % $key_length];
            $result .= $string[$i] ^ $key_char;
        }

        return $result;
    }
}
