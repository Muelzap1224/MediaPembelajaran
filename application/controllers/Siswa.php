<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Siswa extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
        $this->load->helper('string');
        if (!$this->session->userdata('id')) {
            redirect('welcome/murid');
        }
    }
    public function index()
    {
        // MENU DATA
        $data['dashboard'] = [
            'menu' => 'active',
            'expanded' => 'true'
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
        $tugas_siswa_where = [
            'id_siswa' => $this->session->userdata('id'),
            'date_send' => null
        ];
        $data['tugas_siswa'] = $this->db->get_where('tugas_siswa', $tugas_siswa_where)->result();
        $data['materi_siswa'] = $this->db->get_where('materi_siswa', ['id_siswa' => $this->session->userdata('id')])->result();
        $data['kelas'] = $this->db->get('kelas')->result();
        $data['mapel'] = $this->db->get('mapel')->result();
        // $data['siswa'] = $this->db->get_where('siswa', ['nama_siswa' => $this->session->userdata('nama_siswa')])->row_array();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar/siswa', $data);
        $this->load->view('siswa/dashboard', $data);
        $this->load->view('templates/footer');
    }
    public function profile()
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
        $this->form_validation->set_rules('nama_siswa', 'Nama', 'required');
        $data['siswa'] = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();
        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar/siswa', $data);
            $this->load->view('siswa/profile');
            $this->load->view('templates/footer');
        } else {
            $this->db->set('nama_siswa', htmlspecialchars($this->input->post('nama_siswa')));

            if ($_FILES['avatar']['name']) {

                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '5048';
                $config['upload_path'] = './assets/app-assets/user/';
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('avatar')) {
                    $this->db->set('avatar', $this->upload->data('file_name'));
                    $old_image = $data['siswa']->avatar;
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/app-assets/user/' . $old_image);
                    }
                }
            }
            $this->db->where('id_siswa', $this->session->userdata('id'));
            $this->db->update('siswa');

            $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Profile telah diubah',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
            redirect('siswa/profile');
        }
    }
    public function materi()
    {
        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
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
        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();

        $data['materi'] = $this->db->get_where('materi', ['id_kelas' => $siswa->id_kelas])->result();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/siswa', $data);
        $this->load->view('siswa/materi/list', $data);
        $this->load->view('templates/footer');
    }
    public function lihat_materi($data_id_materi = '')
    {
        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
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


        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();
        $data['materi'] = $this->db->get_where('materi', ['id_materi' => decrypt_url($data_id_materi), 'id_kelas' => $siswa->id_kelas])->row();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $data['materi']->id_guru])->row();
        $data['file'] = $this->db->get_where('file', ['id_materi' => $data['materi']->id_materi])->result();

        $siswa_materi_where = [
            'id_materi' => $data['materi']->id_materi,
            'id_siswa' => $this->session->userdata('id')
        ];

        $siswa_materi = $this->db->get_where('materi_siswa', $siswa_materi_where)->row();
        if ($siswa_materi) {
            $this->db->delete('materi_siswa', $siswa_materi_where);
        }

        $data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $data['materi']->id_mapel])->row();
        $data['kelas'] = $this->db->get_where('kelas', ['id_kelas' => $data['materi']->id_kelas])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/siswa', $data);
        $this->load->view('siswa/materi/lihat-materi', $data);
        $this->load->view('templates/footer');
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

        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();

        $data['tugas'] = $this->db->get_where('tugas', ['id_kelas' => $siswa->id_kelas])->result();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/siswa', $data);
        $this->load->view('siswa/tugas/list', $data);
        $this->load->view('templates/footer');
    }

    public function lihat_tugas($data_id_tugas = '')
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

        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();

        $data['tugas'] = $this->db->get_where('tugas', ['id_tugas' => decrypt_url($data_id_tugas), 'id_kelas' => $siswa->id_kelas])->row();
        $data['tugas_siswa'] = $this->db->get_where('tugas_siswa', ['id_tugas' => $data['tugas']->id_tugas, 'id_siswa' => $this->session->userdata('id')])->row();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $data['tugas']->id_guru])->row();
        $data['tufile'] = $this->db->get_where('tufile', ['id_tugas' => $data['tugas']->id_tugas])->result();

        $data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $data['tugas']->id_mapel])->row();
        $data['kelas'] = $this->db->get_where('kelas', ['id_kelas' => $data['tugas']->id_kelas])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/siswa', $data);
        $this->load->view('siswa/tugas/lihat-tugas', $data);
        $this->load->view('templates/footer');
    }
    public function kerjakan_tugas($data_id_tugas = '', $data_id_siswa = '')
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

        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();

        $data['tugas'] = $this->db->get_where('tugas', ['id_tugas' => decrypt_url($data_id_tugas), 'id_kelas' => $siswa->id_kelas])->row();
        $data['guru'] = $this->db->get_where('guru', ['id_guru' => $data['tugas']->id_guru])->row();
        $data['tufile'] = $this->db->get_where('tufile', ['id_tugas' => $data['tugas']->id_tugas])->result();

        $data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $data['tugas']->id_mapel])->row();
        $data['kelas'] = $this->db->get_where('kelas', ['id_kelas' => $data['tugas']->id_kelas])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/siswa', $data);
        //$this->load->view('siswa/tugas/kerjakan-tugas', $data);
        $this->load->view('templates/footer');
    }

    public function kumpulkan()
    {

        $id_tugas = $this->input->post('kode_tugas');
        $tugas = $this->db->get_where('tugas', ['id_tugas' => $id_tugas])->row();
        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();
        $tugas_siswa = $this->db->get_where('tugas_siswa', ['id_tugas' => $id_tugas, 'id_siswa' => $siswa->id_siswa])->row();

        $file_siswa = null;
        if ($tugas_siswa->file_siswa === null) {
            $file_siswa = random_string('numeric',3);
        }
        // Cek Tugas Telat
        $telat = '';
        $waktu =  date('Y-m-d H:i', time());
        $batas = date($tugas->due_date);
        if (strtotime($waktu) > strtotime($batas)) {
            echo "<b>Batas waktu sudah berakhir</b><br>";
            $telat = 1;
        } else {
            echo "<b>Masih dalam jangka waktu</b><br>";
            $telat = 0;
        }

        $data_tugas = [
            'text_siswa' => htmlspecialchars($this->input->post('text_siswa')),
            'date_send' => time(),
            'is_telat' => $telat,
        ];


        $this->db->where('id_tugas', $id_tugas);
        $this->db->where('id_siswa', $this->input->post('id_siswa'));
        $this->db->update('tugas_siswa', $data_tugas);

        if ($_FILES['file_siswa']) {

            // Hitung Jumlah File/Gambar yang dipilih
            $jumlahData = count($_FILES['file_siswa']['name']);

            // Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
            for ($i = 0; $i < $jumlahData; $i++) :

                // Inisialisasi Nama,Tipe,Dll.
                $_FILES['tufile']['name']     = $_FILES['file_siswa']['name'][$i];
                $_FILES['tufile']['type']     = $_FILES['file_siswa']['type'][$i];
                $_FILES['tufile']['tmp_name'] = $_FILES['file_siswa']['tmp_name'][$i];
                $_FILES['tufile']['size']     = $_FILES['file_siswa']['size'][$i];

                // Konfigurasi Upload
                $config['upload_path']          = './assets/app-assets/file/';
                $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|ppt|pptx|rar|zip|xlsx|php|js|html|css|txt|iso|mp4|MP4|3gp|3GP|avi|AVI|mkv|MKV|mpeg|MPEG|wmp|WMP';

                // Memanggil Library Upload dan Setting Konfigurasi
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('tufile')) { // Jika Berhasil Upload

                    $fileData = $this->upload->data(); // Lakukan Upload Data

                    // Membuat Variable untuk dimasukkan ke Database
                    $uploadData[$i]['id_tugas'] = $file_siswa;
                    $uploadData[$i]['nama_file'] = $fileData['file_name'];
                }

            endfor; // Penutup For

            if ($uploadData !== null) { // Jika Berhasil Upload
                $this->db->insert_batch('tufile', $uploadData);
            }

            $this->db->set('file_siswa', $file_siswa);
        }

        $this->db->where('id_tugas', $id_tugas);
        $this->db->where('id_siswa', $this->input->post('id_siswa'));
        $this->db->update('tugas_siswa');

        $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Tugas telah dikerjakan',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
        redirect('siswa/lihat_tugas/' . encrypt_url($tugas->id_tugas));
    }
    public function ujian()
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

        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();

        $data['ujian'] = $this->db->get_where('ujian', ['id_kelas' => $siswa->id_kelas])->result();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/siswa', $data);
        $this->load->view('siswa/ujian/list', $data);
        $this->load->view('templates/footer');
    }
    public function lihat_pg($data_id_ujian, $data_id_siswa)
    {
        $id_ujian = decrypt_url($data_id_ujian);
        $id_siswa = decrypt_url($data_id_siswa);

        // MENU DATA
        $data['dashboard'] = [
            'menu' => '',
            'expanded' => 'false'
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

        $siswa = $this->db->get_where('siswa', ['id_siswa' => $this->session->userdata('id')])->row();

        $data['ujian'] = $this->db->get_where('ujian', ['id_ujian' => $id_ujian])->row();
        $data['detail_ujian'] = $this->db->get_where('ujian_detail', ['id_ujian' => $data['ujian']->id_ujian])->result();

        $data['ujian_siswa'] = $this->db->get_where('ujian_siswa', ['id_ujian' => $data['ujian']->id_ujian, 'id_siswa' => $siswa->id_siswa])->result();
        $data['jawaban_benar'] = $this->db->get_where('ujian_siswa', ['id_ujian' => $data['ujian']->id_ujian, 'id_siswa' => $siswa->id_siswa, 'benar' => 1])->result();
        $data['jawaban_salah'] = $this->db->get_where('ujian_siswa', ['id_ujian' => $data['ujian']->id_ujian, 'id_siswa' => $siswa->id_siswa, 'benar' => 0])->result();
        $data['tidak_dijawab'] = $this->db->get_where('ujian_siswa', ['id_ujian' => $data['ujian']->id_ujian, 'id_siswa' => $siswa->id_siswa, 'benar' => 2])->result();

        $data['mapel'] = $this->db->get('mapel')->result();
        $data['kelas'] = $this->db->get('kelas')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar/siswa', $data);
        $this->load->view('siswa/ujian/pg-lihat', $data);
        $this->load->view('templates/footer');
    }
    public function kirim_ujian()
    {
        $id_ujian = $this->input->post('ujian');
        $siswa = $this->input->post('siswa');

        $detail_ujian = $this->db->get_where('ujian_detail', ['id_ujian' => $id_ujian])->result();

        foreach ($detail_ujian as $du) {
            if ($this->input->post("$du->id_detail_ujian") == $du->jawaban) {
                $this->db->set('jawaban', $this->input->post("$du->id_detail_ujian"));
                $this->db->set('benar', 1);
                $this->db->where('id_detail_ujian', $du->id_detail_ujian);
                $this->db->where('id_siswa', $siswa);
                $this->db->update('ujian_siswa');
            } else {
                if ($this->input->post("$du->id_detail_ujian") == NULL) {
                    $this->db->set('jawaban', $this->input->post("$du->id_detail_ujian"));
                    $this->db->set('benar', 2);
                    $this->db->where('id_detail_ujian', $du->id_detail_ujian);
                    $this->db->where('id_siswa', $siswa);
                    $this->db->update('ujian_siswa');
                } else {
                    $this->db->set('jawaban', $this->input->post("$du->id_detail_ujian"));
                    $this->db->set('benar', 0);
                    $this->db->where('id_detail_ujian', $du->id_detail_ujian);
                    $this->db->where('id_siswa', $siswa);
                    $this->db->update('ujian_siswa');
                }
            }
        }

        $ujian = $this->db->get_where('ujian', ['id_ujian' => $id_ujian])->row();

        $this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Ujian telah dikerjakan',
                            type: 'success',
                            padding: '2em'
                            });
                        ");
        redirect('siswa/lihat_pg/' . encrypt_url($ujian->id_ujian) . '/' . encrypt_url($siswa));
    }
}
