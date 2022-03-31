<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{

    public function edit_siswa()
    {
        if ($this->input->is_ajax_request()) {
            $siswa = decrypt_url($this->input->post('id_siswa'));
            $data_siswa = $this->db->get_where('siswa', ['id_siswa' => $siswa])->row();
            echo json_encode($data_siswa);
        } else {
            redirect('eror');
        }
    }

    public function edit_guru()
    {
        if ($this->input->is_ajax_request()) {
            $guru = decrypt_url($this->input->post('id_guru'));
            $data_guru = $this->db->get_where('guru', ['id_guru' => $guru])->row();
            echo json_encode($data_guru);
        } else {
            redirect('eror');
        }
    }

    public function edit_materi()
    {
        if ($this->input->is_ajax_request()) {
            $materi = decrypt_url($this->input->post('id_materi'));
            $data_materi = $this->db->get_where('materi', ['id_materi' => $materi])->row();
            echo json_encode($data_materi);
        } else {
            redirect('eror');
        }
    }

    public function edit_tugas()
    {
        if ($this->input->is_ajax_request()) {
            $tugas = decrypt_url($this->input->post('id_tugas'));
            $data_tugas = $this->db->get_where('tugas', ['id_tugas' => $tugas])->row();
            echo json_encode($data_tugas);
        } else {
            redirect('eror');
        }
    }

    public function time_now()
    {
        date_default_timezone_set('Asia/Jakarta');
        echo date('H:i:s', time());
    }

    public function cek_ujian()
    {
        if ($this->input->is_ajax_request()) {
            $kode_ujian = $this->input->post('kode_ujian');
            $waktu = $this->input->post('waktu');
            $ujian = $this->db->get_where('ujian', ['id_ujian' => $kode_ujian])->row();

            if (strtotime($waktu) > strtotime($ujian->waktu_berakhir)) {
                echo "1";
            } else {
                echo "0";
            }
            exit;
        } else {
            redirect('eror');
        }
    }

    public function cek_no_induk()
    {
        if ($this->input->is_ajax_request()) {
            $no_induk = $this->input->post('no_induk');
            $hasil = $this->db->get_where('siswa', ['no_induk_siswa' => $no_induk])->row();
            if ($hasil) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('eror');
        }
    }

    public function upload_summernote()
    {
        $this->load->library('upload');
        if (isset($_FILES["image"]["name"])) {
            $config['upload_path'] = './assets/app-assets/file/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $this->upload->display_errors();
                return FALSE;
            } else {
                $data = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/app-assets/file/' . $data['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['new_image'] = './assets/app-assets/file/' . $data['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                echo base_url() . 'assets/app-assets/file/' . $data['file_name'];
            }
        }
    }

    function delete_image()
    {
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if (unlink($file_name)) {
            echo 'File Delete Successfully';
        }
    }
}
