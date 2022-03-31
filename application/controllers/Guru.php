<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Guru extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
        $this->load->helper('string');

        if (!$this->session->userdata('id')) {
            redirect('welcome/guru');
        } 
    }
    public function index()
    {
        $data['dashboard'] = [
            'menu' => 'active',
            'expanded' => 'true'
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $this->session->userdata('id')])->row();

        $data['siswa'] = $this->db->get('siswa')->result();
        $data['kelas'] = $this->db->get('kelas')->result();
        $data['mapel'] = $this->db->get('mapel')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar/guru', $data);
        $this->load->view('guru/dashboard', $data);
        $this->load->view('templates/footer');;
    }
    public function profile()
    {

        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];

        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $this->session->userdata('id')])->row();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();



        $this->form_validation->set_rules('nama_guru', 'Guru', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar/guru', $data);
            $this->load->view('guru/profile', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->set('nama_guru', htmlspecialchars($this->input->post('nama_guru')));

            if ($_FILES['avatar']['name']) {

                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '5048';
                $config['upload_path'] = './assets/app-assets/user/';
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('avatar')) {
                    $this->db->set('avatar', $this->upload->data('file_name'));
                    $old_image = $data['guru']->avatar;
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/app-assets/user/' . $old_image);
                    }
                }
            }

            $this->db->where('id_guru', $this->session->userdata('id'));
            $this->db->update('guru');

            $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Profile telah diubah',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
            redirect('guru/profile');
        }
    }
    public function siswa()
    {
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => 'active',
            'expanded' => 'true',
            'collapse' => 'show'
        ];
        $data['sub_master'] = [
            'siswa' => 'active',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['siswa'] = $this->db->get('siswa')->result();
        $data['kelas'] = $this->db->get('kelas')->result();

        $this->form_validation->set_rules('nis[]', 'Nomor Induk', 'required');
        $this->form_validation->set_rules('nama_siswa[]', 'Nama Siswa', 'required');
        $this->form_validation->set_rules('password[]', 'Password', 'required');
        $this->form_validation->set_rules('jenis_kelamin[]', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('id_kelas[]', 'Id Kelas', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar/guru', $data);
            $this->load->view('siswa/list', $data);
            $this->load->view('templates/footer');
        } else {
            // Ambil data yang dikirim dari form
            $nama_siswa = $this->input->post('nama_siswa');
            $data_siswa = array();
            $index = 0; // Set index array awal dengan 0
            foreach ($nama_siswa as $nama) { // Kita buat perulangan berdasarkan nama_siswa sampai data terakhir
                $kelas = $this->db->get_where('kelas', ['id_kelas' => $this->input->post('kelas')[$index]])->row();
                array_push($data_siswa, array(
                    'no_induk_siswa' => $this->input->post('nis')[$index],
                    'nama_siswa' => $nama,
                    'password' => $this->input->post('password')[$index],
                    'jenis_kelamin' => $this->input->post('jenis_kelamin')[$index],
                    'id_kelas' => $this->input->post('id_kelas')[$index],
                    'role' => 2,
                    'date_created' => time(),
                    'avatar' => 'default.jpg'
                ));
            }
            $sql = $this->db->insert_batch('siswa', $data_siswa);

            // Cek apakah query insert nya sukses atau gagal
            if ($sql) { // Jika sukses
                $this->session->set_flashdata('pesan', "
                swal({
                    title: 'Berhasil!',
                    text: 'data disimpan',
                    type: 'success',
                    padding: '2em'
                    })
                ");
                redirect('guru/siswa?pesan=success');
            } else { // Jika gagal
                $this->session->set_flashdata('pesan', "
                swal({
                    title: 'Error!',
                    text: 'gagal disimpan',
                    type: 'error',
                    padding: '2em'
                    })
                ");
                redirect('guru/siswa?pesan=success');
            }
        }
    }
    public function hapus_siswa($id = '')
    {
        $id_siswa = decrypt_url($id);
        $this->db->delete('siswa', ['id_siswa' => $id_siswa]);
        $this->session->set_flashdata('pesan', "
                swal({
                    title: 'Berhasil!',
                    text: 'data dihapus',
                    type: 'success',
                    padding: '2em'
                    })
                ");
        redirect('guru/siswa');
    }


    public function ust()
    {
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => 'active',
            'expanded' => 'true',
            'collapse' => 'show'
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => 'active'
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['siswa'] = $this->db->get('siswa')->result();
        $data['guru'] = $this->db->get('guru')->result();
        $data['kelas'] = $this->db->get('kelas')->result();

        $this->form_validation->set_rules('nama_guru[]', 'Nama Guru', 'required');
        $this->form_validation->set_rules('password[]', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar/guru', $data);
            $this->load->view('guru/list', $data);
            $this->load->view('templates/footer');
        } else {
            $nama_guru = $this->input->post('nama_guru');

            $data_guru = array();
            $index = 0; // Set index array awal dengan 0
            foreach ($nama_guru as $nama) { // Kita buat perulangan berdasarkan nama_guru sampai data terakhir
                array_push($data_guru, array(
                    'nama_guru' => $nama,
                    'password' => $this->input->post('password')[$index],
                    'role' => 1,
                    'date_created' => time(),
                    'avatar' => 'default.jpg'
                ));
            }
            $sql = $this->db->insert_batch('guru', $data_guru);
            if ($sql) { // Jika sukses
                $this->session->set_flashdata('pesan', "
                swal({
                    title: 'Berhasil!',
                    text: 'data disimpan',
                    type: 'success',
                    padding: '2em'
                    })
                ");
                redirect('guru/ust?pesan=success');
            } else { // Jika gagal
                $this->session->set_flashdata('pesan', "
                swal({
                    title: 'Error!',
                    text: 'gagal disimpan',
                    type: 'error',
                    padding: '2em'
                    })
                ");
                redirect('guru/ust?pesan=success');
            }
        }
    }
    public function hapus_ust($id = '')
    {
        $id_guru = decrypt_url($id);
        $this->db->delete('guru', ['id_guru' => $id_guru]);
        $this->session->set_flashdata('pesan', "
                swal({
                    title: 'Berhasil!',
                    text: 'data dihapus',
                    type: 'success',
                    padding: '2em'
                    })
                ");
        redirect('guru/ust');
    }

    public function ujian()
    {
        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['ujian'] = $this->db->get_where('ujian', ['id_guru' => $this->session->userdata('id')])->result();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $this->session->userdata('id')])->row();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();


        $this->load->view('templates/header');
        $this->load->view('templates/sidebar/guru', $data);
        $this->load->view('guru/ujian/list', $data);
        $this->load->view('templates/footer');
    }
    public function tambah_pg()
    {
        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['ujian'] = $this->db->get_where('ujian', ['id_guru' => $this->session->userdata('id')])->result();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $this->session->userdata('id')])->row();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();
        $this->form_validation->set_rules('nama_ujian', 'Nama Ujian', 'required');
        $this->form_validation->set_rules('kelas', 'kelas', 'required');
        $this->form_validation->set_rules('mapel', 'Mapel', 'required');
        $this->form_validation->set_rules('tgl_mulai', 'tgl mulai', 'required');
        $this->form_validation->set_rules('jam_mulai', 'jam mulai', 'required');
        $this->form_validation->set_rules('tgl_berakhir', 'tgl berakhir', 'required');
        $this->form_validation->set_rules('jam_berakhir', 'jam berakhir', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar/guru', $data);
            $this->load->view('guru/ujian/pg_tambah');
            $this->load->view('templates/footer');
        } else {
            $id_siswa = $this->db->get_where('siswa', ['id_kelas' => $this->input->post('kelas')])->result();
            $kode_ujian = random_string('numeric', 4);
            $data_ujian = [
                'id_ujian' => $kode_ujian,
                'nama_ujian' => $this->input->post('nama_ujian'),
                'id_guru' => $this->session->userdata('id'),
                'id_kelas' => $this->input->post('kelas'),
                'id_mapel' => $this->input->post('mapel'),
                'date_created' => time(),
                'waktu_mulai' => $this->input->post('tgl_mulai') . ' ' . $this->input->post('jam_mulai'),
                'waktu_berakhir' => $this->input->post('tgl_berakhir') . ' ' . $this->input->post('jam_berakhir')
            ];
            // END DATA UJIAN
            // DATA DETAIL UJIAN PG
            $nama_soal = $this->input->post('nama_soal');
            $data_detail_ujian = array();
            $index = 0;
            foreach ($nama_soal as $nama) {
                array_push($data_detail_ujian, array(
                    'id_ujian' => $kode_ujian,
                    'nama_soal' => $nama,
                    'pg_1' => 'A. ' . $this->input->post('pg_1')[$index],
                    'pg_2' => 'B. ' . $this->input->post('pg_2')[$index],
                    'pg_3' => 'C. ' . $this->input->post('pg_3')[$index],
                    'pg_4' => 'D. ' . $this->input->post('pg_4')[$index],
                    'jawaban' => $this->input->post('jawaban')[$index],
                ));

                $index++;
            }
            // END DATA DETAIL UJIAN PG
            $this->db->insert('ujian', $data_ujian);
            $this->db->insert_batch('ujian_detail', $data_detail_ujian);
            $ujian_detail = $this->db->get_where('ujian_detail', ['id_ujian' => $kode_ujian])->result();
            $data_ujian_siswa = [];
            foreach ($ujian_detail as $uj) {
                foreach ($id_siswa as $su) {
                    array_push($data_ujian_siswa, [
                        'id_detail_ujian' => $uj->id_detail_ujian,
                        'id_ujian' => $uj->id_ujian,
                        'id_siswa' => $su->id_siswa,
                    ]);
                }
            }
            $this->db->insert_batch('ujian_siswa', $data_ujian_siswa);

            $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Ujian telah dibuat',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
            redirect('guru/ujian?pesan=success');
        }
    }
    public function lihat_ujian($data_id_ujian, $data_id_guru)
    {
        $id_ujian = decrypt_url($data_id_ujian);
        $id_guru = decrypt_url($data_id_guru);

        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['ujian'] = $this->db->get_where('ujian', ['id_ujian' => $id_ujian, 'id_guru' => $id_guru])->row();
        $data['detail_ujian'] = $this->db->get_where('ujian_detail', ['id_ujian' => $data['ujian']->id_ujian])->result();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $this->session->userdata('id')])->row();
        $data['siswa'] = $this->db->get_where('siswa', ['id_kelas' => $data['ujian']->id_kelas])->result();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar/guru', $data);
        $this->load->view('guru/ujian/pg-lihat', $data);
        $this->load->view('templates/footer');
    }

    public function hapus_ujian($data_id_ujian, $data_id_guru)
    {
        $id_ujian = decrypt_url($data_id_ujian);
        $id_guru = decrypt_url($data_id_guru);

        $ujian = $this->db->get_where('ujian', ['id_ujian' => $id_ujian])->row();

        $this->db->delete('ujian_siswa', ['id_ujian' => $ujian->id_ujian]);
        $this->db->delete('ujian_detail', ['id_ujian' => $ujian->id_ujian]);
        $this->db->delete('ujian', ['id_ujian' => $ujian->id_ujian]);


        $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Ujian telah dihapus',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
        redirect('guru/ujian');
    }
    public function materi()
    {
        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'

        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['materi'] = $this->db->get_where('materi', ['id_guru' => $this->session->userdata('id')])->result();
        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();

        $this->form_validation->set_rules('nama_materi', 'Nama Materi', 'required');
        $this->form_validation->set_rules('mapel', 'Mapel', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('text_materi', 'teks materi', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar/guru', $data);
            $this->load->view('guru/materi/list', $data);
            $this->load->view('templates/footer');
        } else {

            $data_materi = [
                'id_materi' => $this->input->post('kode_materi'),
                'nama_materi' => $this->input->post('nama_materi'),
                'id_guru' => $this->session->userdata('id'),
                'id_mapel' => $this->input->post('mapel'),
                'id_kelas' => $this->input->post('kelas'),
                'text_materi' => htmlspecialchars($this->input->post('text_materi', true)),
                'date_created' => time()
            ];
            $siswa = $this->db->get_where('siswa', ['id_kelas' => $this->input->post('kelas')])->result();
            $this->db->insert('materi', $data_materi);
            if ($_FILES['file_materi']) {

                // Hitung Jumlah File/Gambar yang dipilih
                $jumlahData = count($_FILES['file_materi']['name']);

                // Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
                for ($i = 0; $i < $jumlahData; $i++) :

                    // Inisialisasi Nama,Tipe,Dll.
                    $_FILES['file']['name']     = $_FILES['file_materi']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['file_materi']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['file_materi']['tmp_name'][$i];
                    $_FILES['file']['size']     = $_FILES['file_materi']['size'][$i];

                    // Konfigurasi Upload
                    $config['upload_path']          = './assets/app-assets/file/';
                    $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|ppt|pptx|rar|zip|xlsx|php|js|html|css|txt|iso';

                    // Memanggil Library Upload dan Setting Konfigurasi
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) { // Jika Berhasil Upload

                        $fileData = $this->upload->data(); // Lakukan Upload Data

                        // Membuat Variable untuk dimasukkan ke Database
                        $uploadData[$i]['id_materi'] = $this->input->post('kode_materi');
                        $uploadData[$i]['nama_file'] = $fileData['file_name'];
                    }

                endfor; // Penutup For

                if ($uploadData !== null) { // Jika Berhasil Upload
                    $this->db->insert_batch('file', $uploadData);
                }
            }

            if ($_FILES['video_materi']) {
                // Hitung Jumlah File/Gambar yang dipilih
                $jumlahData_video = count($_FILES['video_materi']['name']);

                // Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
                for ($i = 0; $i < $jumlahData_video; $i++) :

                    // Inisialisasi Nama,Tipe,Dll.
                    $_FILES['file']['name']     = $_FILES['video_materi']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['video_materi']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['video_materi']['tmp_name'][$i];
                    $_FILES['file']['size']     = $_FILES['video_materi']['size'][$i];

                    // Konfigurasi Upload
                    $config_video['upload_path']          = './assets/app-assets/file/';
                    $config_video['allowed_types']        = 'mp4|MP4|3gp|3GP|avi|AVI|mkv|MKV|mpeg|MPEG|wmp|WMP';

                    // Memanggil Library Upload dan Setting Konfigurasi
                    $this->load->library('upload', $config_video);
                    $this->upload->initialize($config_video);

                    if ($this->upload->do_upload('file')) { // Jika Berhasil Upload

                        $fileData_video = $this->upload->data(); // Lakukan Upload Data

                        // Membuat Variable untuk dimasukkan ke Database
                        $uploadData_video[$i]['id_materi'] = $this->input->post('kode_materi');
                        $uploadData_video[$i]['nama_file'] = $fileData_video['file_name'];
                    }

                endfor; // Penutup For

                if ($uploadData_video !== null) { // Jika Berhasil Upload
                    $this->db->insert_batch('file', $uploadData_video);
                }
            }
            $siswa_materi = [];
            $index_siswa_materi = 0;
            foreach ($siswa as $s2) {
                array_push($siswa_materi, array(
                    'id_materi' => $this->input->post('kode_materi'),
                    'id_kelas' => $this->input->post('kelas'),
                    'id_mapel' => $this->input->post('mapel'),
                    'id_siswa' => $s2->id_siswa,
                    'dilihat' => 0
                ));
            }
            $this->db->insert_batch('materi_siswa', $siswa_materi);

            $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Materi telah dibuat',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
            redirect('guru/materi?pesan=success');
        }
    }
    public function lihat_materi($data_id_materi, $data_id_guru)
    {
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'

        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_tugas'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $materi_where = [
            'id_materi' => decrypt_url($data_id_materi),
            'id_guru' => decrypt_url($data_id_guru)
        ];
        $data['materi'] = $this->db->get_where('materi', $materi_where)->row();
        $data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $data['materi']->id_mapel])->row();
        $data['kelas'] = $this->db->get_where('kelas', ['id_kelas' => $data['materi']->id_kelas])->row();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $data['materi']->id_guru])->row();

        $data['file'] = $this->db->get_where('file', ['id_materi' => $data['materi']->id_materi])->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/guru', $data);
        $this->load->view('guru/materi/lihat-materi', $data);
        $this->load->view('templates/footer');
    }
    public function edit_materi()
    {
        $id_materi = $this->input->post('e_id_materi');
        $data = [
            'nama_materi' => $this->input->post('e_nama_materi'),
            'mapel' => $this->input->post('e_mapel'),
            'kelas' => $this->input->post('e_kelas'),
            'text_materi' => $this->input->post('e_text_materi'),
        ];
        $this->db->where('id_mater', $id_materi);
        $this->db->update('materi', $data);

        if ($_FILES['e_file_materi']) {

            // Hitung Jumlah File/Gambar yang dipilih
            $jumlahData = count($_FILES['e_file_materi']['name']);

            // Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
            for ($i = 0; $i < $jumlahData; $i++) :

                // Inisialisasi Nama,Tipe,Dll.
                $_FILES['file']['name']     = $_FILES['e_file_materi']['name'][$i];
                $_FILES['file']['type']     = $_FILES['e_file_materi']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['e_file_materi']['tmp_name'][$i];
                $_FILES['file']['size']     = $_FILES['e_file_materi']['size'][$i];

                // Konfigurasi Upload
                $config['upload_path']          = './assets/app-assets/file/';
                $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|ppt|pptx|rar|zip|xlsx|php|js|html|css|txt|iso';

                // Memanggil Library Upload dan Setting Konfigurasi
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) { // Jika Berhasil Upload

                    $fileData = $this->upload->data(); // Lakukan Upload Data

                    // Membuat Variable untuk dimasukkan ke Database
                    $uploadData[$i]['kode_file'] = $id_materi;
                    $uploadData[$i]['nama_file'] = $fileData['file_name'];
                }

            endfor; // Penutup For

            if ($uploadData !== null) { // Jika Berhasil Upload
                $this->db->insert_batch('file', $uploadData);
            }
        }

        if ($_FILES['e_video_materi']) {
            // Hitung Jumlah File/Gambar yang dipilih
            $jumlahData = count($_FILES['e_video_materi']['name']);

            // Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
            for ($i = 0; $i < $jumlahData; $i++) :

                // Inisialisasi Nama,Tipe,Dll.
                $_FILES['file']['name']     = $_FILES['e_video_materi']['name'][$i];
                $_FILES['file']['type']     = $_FILES['e_video_materi']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['e_video_materi']['tmp_name'][$i];
                $_FILES['file']['size']     = $_FILES['e_video_materi']['size'][$i];

                // Konfigurasi Upload
                $config['upload_path']          = './assets/app-assets/file/';
                $config['allowed_types']        = 'mp4|MP4|3gp|3GP|avi|AVI|mkv|MKV|mpeg|MPEG|wmp|WMP';

                // Memanggil Library Upload dan Setting Konfigurasi
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) { // Jika Berhasil Upload

                    $fileData = $this->upload->data(); // Lakukan Upload Data

                    // Membuat Variable untuk dimasukkan ke Database
                    $uploadData[$i]['kode_file'] = $id_materi;
                    $uploadData[$i]['nama_file'] = $fileData['file_name'];
                }

            endfor; // Penutup For

            if ($uploadData !== null) { // Jika Berhasil Upload
                $this->db->insert_batch('file', $uploadData);
            }
        }
        $this->session->set_flashdata('pesan', "
        swal({
            title: 'Berhasil!',
            text: 'Materi telah diupdate',
            type: 'success',
            padding: '2em'
            });
        ");
        redirect('guru/materi');
    }
    public function hapus_materi($data_id_materi, $data_id_guru)
    {
        $materi_where = [
            'id_materi' => decrypt_url($data_id_materi),
            'id_guru' => decrypt_url($data_id_guru)
        ];
        $materi = $this->db->get_where('materi', $materi_where)->row();

        $this->db->delete('materi', $materi_where);


        $this->db->delete('materi_siswa', ['id_materi' => $materi->id_materi]);

        $file = $this->db->get_where('file', ['id_materi' => $materi->id_materi])->result();

        foreach ($file as $f) {
            if ($f->id_materi == $materi->id_materi) {
                unlink(FCPATH . 'assets/app-assets/file/' . $f->nama_file);
                $this->db->delete('file', ['id_materi' => $materi->id_materi]);
            }
        }

        $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Materi telah dihapus',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
        redirect('guru/materi');
    }
    public function tugas()
    {
        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_tugas'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['tugas'] = $this->db->get_where('tugas', ['id_guru' => $this->session->userdata('id')])->result();
        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();
        $this->form_validation->set_rules('nama_tugas', 'Nama Tugas', 'required');
        $this->form_validation->set_rules('mapel', 'Mapel', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar/guru', $data);
            $this->load->view('guru/tugas/list', $data);
            $this->load->view('templates/footer');
        } else {
            $data_tugas = [
                'id_tugas' => $this->input->post('kode_tugas'),
                'id_kelas' => $this->input->post('kelas'),
                'id_mapel' => $this->input->post('mapel'),
                'id_guru' => $this->session->userdata('id'),
                'nama_tugas' => $this->input->post('nama_tugas'),
                'deskripsi' => htmlspecialchars($this->input->post('deskripsi', true)),
                'date_created' => time(),
                'due_date' => $this->input->post('tgl') . ' ' . $this->input->post('jam')
            ];


            $siswa = $this->db->get_where('siswa', ['id_kelas' => $this->input->post('kelas')])->result();
            $data_siswa = [];
            $index_siswa = 0;
            foreach ($siswa as $s) {
                array_push($data_siswa, array(
                    'id_tugas' => $this->input->post('kode_tugas'),
                    'id_siswa' => $s->id_siswa
                ));

                $index_siswa++;
            }
            $this->db->insert('tugas', $data_tugas);
            $this->db->insert_batch('tugas_siswa', $data_siswa);
            if ($_FILES['file_materi']) {

                // Hitung Jumlah File/Gambar yang dipilih
                $jumlahData = count($_FILES['file_materi']['name']);

                // Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
                for (
                    $i = 0;
                    $i < $jumlahData;
                    $i++
                ) :

                    // Inisialisasi Nama,Tipe,Dll.
                    $_FILES['tufile']['name']     = $_FILES['file_materi']['name'][$i];
                    $_FILES['tufile']['type']     = $_FILES['file_materi']['type'][$i];
                    $_FILES['tufile']['tmp_name'] = $_FILES['file_materi']['tmp_name'][$i];
                    $_FILES['tufile']['size']     = $_FILES['file_materi']['size'][$i];

                    // Konfigurasi Upload
                    $config['upload_path']          = './assets/app-assets/file/';
                    $config['allowed_types']        = 'jpeg|gif|jpg|png|pdf|doc|docx|ppt|pptx|rar|zip|xlsx|php|js|html|css|txt|iso';

                    // Memanggil Library Upload dan Setting Konfigurasi
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('tufile')) { // Jika Berhasil Upload

                        $fileData = $this->upload->data(); // Lakukan Upload Data

                        // Membuat Variable untuk dimasukkan ke Database
                        $uploadData[$i]['id_tugas'] = $this->input->post('kode_tugas');
                        $uploadData[$i]['nama_file'] = $fileData['file_name'];
                    }

                endfor; // Penutup For

                if ($uploadData !== null) { // Jika Berhasil Upload
                    $this->db->insert_batch('tufile', $uploadData);
                }
            }

            if ($_FILES['video_materi']) {
                // Hitung Jumlah File/Gambar yang dipilih
                $jumlahData_video = count($_FILES['video_materi']['name']);

                // Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
                for ($i = 0; $i < $jumlahData_video; $i++) :

                    // Inisialisasi Nama,Tipe,Dll.
                    $_FILES['tufile']['name']     = $_FILES['video_materi']['name'][$i];
                    $_FILES['tufile']['type']     = $_FILES['video_materi']['type'][$i];
                    $_FILES['tufile']['tmp_name'] = $_FILES['video_materi']['tmp_name'][$i];
                    $_FILES['tufile']['size']     = $_FILES['video_materi']['size'][$i];

                    // Konfigurasi Upload
                    $config_video['upload_path']          = './assets/app-assets/file/';
                    $config_video['allowed_types']        = 'mp4|MP4|3gp|3GP|avi|AVI|mkv|MKV|mpeg|MPEG|wmp|WMP';

                    // Memanggil Library Upload dan Setting Konfigurasi
                    $this->load->library('upload', $config_video);
                    $this->upload->initialize($config_video);

                    if ($this->upload->do_upload('tufile')) { // Jika Berhasil Upload

                        $fileData_video = $this->upload->data(); // Lakukan Upload Data

                        // Membuat Variable untuk dimasukkan ke Database
                        $uploadData_video[$i]['id_tugas'] = $this->input->post('kode_tugas');
                        $uploadData_video[$i]['nama_file'] = $fileData_video['file_name'];
                    }

                endfor; // Penutup For

                if ($uploadData_video !== null) { // Jika Berhasil Upload
                    $this->db->insert_batch('tufile', $uploadData_video);
                }
            }
            $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Tugas telah dibuat',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
            redirect('guru/tugas?pesan=success');
        }
    }
    public function lihat_tugas($data_id_tugas, $data_id_guru)
    {
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];

        $data['menu_tugas'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $tugas_where = [
            'id_tugas' => decrypt_url($data_id_tugas),
            'id_guru' => decrypt_url($data_id_guru)
        ];
        $data['tugas'] = $this->db->get_where('tugas', $tugas_where)->row();
        $data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $data['tugas']->id_mapel])->row();
        $data['kelas'] = $this->db->get_where('kelas', ['id_kelas' => $data['tugas']->id_kelas])->row();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $data['tugas']->id_guru])->row();

        $data['file'] = $this->db->get_where('tufile', ['id_tugas' => $data['tugas']->id_tugas])->result();
        $data['tugas_siswa'] = $this->db->get_where('tugas_siswa', ['id_tugas' => $data['tugas']->id_tugas])->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/guru', $data);
        $this->load->view('guru/tugas/lihat-tugas', $data);
        $this->load->view('templates/footer');
    }
    public function tugas_siswa($data_tugas, $data_siswa)
    {
        $tugas = decrypt_url($data_tugas);
        $siswa = decrypt_url($data_siswa);


        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
        ];
        $data['master'] = [
            'menu' => '',
            'expanded' => 'false',
            'collapse' => ''
        ];
        $data['sub_master'] = [
            'siswa' => '',
            'guru' => ''
        ];
        $data['menu_materi'] = [
            'menu' => '',
            'expanded' => 'false',
        ];

        $data['menu_tugas'] = [
            'menu' => 'active',
            'expanded' => 'true',
        ];
        $data['menu_ujian'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['menu_profile'] = [
            'menu' => '',
            'expanded' => 'false',
        ];
        $data['siswa'] = $this->db->get_where('siswa', ['id_siswa' => $siswa])->row();
        $data['tugas_siswa'] = $this->db->get_where('tugas_siswa', ['id_tugas' => $tugas, 'id_siswa' => $siswa])->row();
        $data['tugas'] = $this->db->get_where('tugas', ['id_tugas' => $tugas])->row();
        $data['file'] = $this->db->get_where('tufile', ['id_tugas' => $data['tugas_siswa']->file_siswa])->result();

        $this->form_validation->set_rules('tugas', 'Tugas', 'required');
        $this->form_validation->set_rules('siswa', 'Siswa', 'required');
        $this->form_validation->set_rules('nilai', 'Nilai', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar/guru', $data);
            $this->load->view('guru/tugas/tugas-siswa', $data);
            $this->load->view('templates/footer');
        } else {

            $tugas = $this->db->get_where('tugas', ['id_tugas' => $this->input->post('tugas')])->row();
            $this->db->set('nilai', $this->input->post('nilai'));

            $this->db->where('id_tugas', $this->input->post('tugas'));
            $this->db->where('id_siswa', $this->input->post('siswa'));
            $this->db->update('tugas_siswa');

            $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Tugas telah Dinilai',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
            redirect('guru/lihat_tugas/' .  encrypt_url($tugas->id_tugas) . '/' . encrypt_url($this->session->userdata('id')));
        }
    }
    public function hapus_tugas($data_id_tugas, $data_id_guru)
    {
        $tugas_where = [
            'id_tugas' => decrypt_url($data_id_tugas),
            'id_guru' => decrypt_url($data_id_guru)
        ];
        $tugas = $this->db->get_where('tugas', $tugas_where)->row();

        $file = $this->db->get_where('tufile', ['id_tugas' => $tugas->id_tugas])->result();

        foreach ($file as $f) {
            if ($f->id_tugas == $tugas->id_tugas) {
                unlink(FCPATH . 'assets/app-assets/file/' . $f->nama_file);
                $this->db->delete('tufile', ['id_tugas' => $tugas->id_tugas]);
            }
        }

        $this->db->delete('tugas', $tugas_where);

        $tugas_siswa = $this->db->get_where('tugas_siswa', ['id_tugas' => $tugas->id_tugas])->result();

        foreach ($tugas_siswa as $ts) {
            $file_siswa = $this->db->get_where('tufile', ['id_tugas' => $ts->file_siswa])->row();
            if ($file_siswa) {
                if ($file_siswa->id_tugas == $ts->file_siswa) {
                    unlink(FCPATH . 'assets/app-assets/file/' . $file_siswa->nama_file);
                    $this->db->delete('tufile', ['id_tugas' => $ts->file_siswa]);
                }
            }
        }

        $this->db->delete('tugas_siswa', ['id_tugas' => $tugas->id_tugas]);

        $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Tugas telah dihapus',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
        redirect('guru/tugas');
    }
}
