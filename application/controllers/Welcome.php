      <?php
		defined('BASEPATH') or exit('No direct script access allowed');

		class Welcome extends CI_Controller
		{
			public function __construct()
			{
				parent::__construct();
				$this->load->library('form_validation');
			}

			public function index()
			{
				$this->load->view('header');
				$this->load->view('carousel');
				$this->load->view('tengah');
				$this->load->view('footer');
			}

			public function guru()
			{

				$this->load->library('form_validation');

				$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
				$this->form_validation->set_rules('password', 'Password', 'required|trim');
				if ($this->form_validation->run() == false) {
					$data['title'] = 'login Guru';
					$this->load->view('login/headerlogin', $data);
					$this->load->view('loguru');
					$this->load->view('login/footerlogin');
				} else {
					//$nama = $this->input->post('nama');

					// Cek Siswa
					//$guru = $this->db->get_where('guru', ['nama' => $nama])->row();
					//if ($guru) {
					$this->loginguru();
				}
			}


			private function loginguru()
			{
				$nama_guru = $this->input->post('nama');
				$password = $this->input->post('password');
				$cek_nama = $this->db->get_where('guru', ['nama_guru' => $nama_guru])->row();
				if ($cek_nama) {
					$cek_pass = $this->db->get_where('guru', ['password' => $password])->row();
					if ($cek_pass) {

						$this->db->from('guru');
						$this->db->where('nama_guru', $nama_guru);
						$ambil_datanya_kek_gini = $this->db->get()->row_array();
						if (isset($ambil_datanya_kek_gini)) {
							// foreach ($ambil_datanya_kek_gini as $row) {
							$session_data = array(
								'id' => $ambil_datanya_kek_gini['id_guru'],
								'nama'	=> $ambil_datanya_kek_gini['nama_guru'],
								'password'	=> $ambil_datanya_kek_gini['password'],
								'role' => $ambil_datanya_kek_gini['role'],
							);
							$this->session->set_userdata($session_data);
							redirect('guru');
							//echo "BERHASIL" . $ambil_datanya_kek_gini['nama_guru'];
							// }
						}
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Passwordmu salah</div>');
						redirect('welcome/guru');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">namamu salah</div>');
					redirect('welcome/guru');
				}
			}
			public function murid()
			{
				$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
				$this->form_validation->set_rules('password', 'Password', 'required|trim');

				if ($this->form_validation->run() == false) {
					$data['title'] = 'login Siswa';
					$this->load->view('login/headerlogin', $data);
					$this->load->view('lomurid');
					$this->load->view('login/footerlogin');
				} else {
					//validasi sukses
					$this->_login();
				}
			}
			private function _login()
			{
				$nama_siswa = $this->input->post('nama');
				$password = $this->input->post('password');
				$cek_nama = $this->db->get_where('siswa', ['nama_siswa' => $nama_siswa])->row();
				if ($cek_nama) {
					$cek_pass = $this->db->get_where('siswa', ['password' => $password])->row();
					if ($cek_pass) {

						$this->db->from('siswa');
						$this->db->where('nama_siswa', $nama_siswa);

						$ambil_datanya_kek_gini = $this->db->get()->row_array();
						if (isset($ambil_datanya_kek_gini)) {
							// foreach ($ambil_datanya_kek_gini as $row) {
							$session_data = array(
								'id' => $ambil_datanya_kek_gini['id_siswa'],
								'nama'	=> $ambil_datanya_kek_gini['nama_siswa'],
								'password'	=> $ambil_datanya_kek_gini['password'],
								'role' => $ambil_datanya_kek_gini['role'],
							);
							$this->session->set_userdata($session_data);
							$this->session->set_flashdata('pesan', "
                        swal({
                            title: 'Berhasil!',
                            text: 'Anda Sudah Login',
                            type: 'success',
                            padding: '2em'
                            })
                        ");
							redirect('siswa');
							//echo "BERHASIL" . $ambil_datanya_kek_gini['nama_siswa'];
							// }
						}
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Passwordmu salah</div>');
						redirect('welcome/murid');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">namamu salah</div>');
					redirect('welcome/murid');
				}
			}
			public function register()

			{
				$this->load->helper('string');
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
				$this->form_validation->set_rules('password', 'Password', 'required|trim');
				if ($this->form_validation->run() == false) {
					$data['title'] = 'Form Daftar Siswa';
					$this->load->view('login/headerlogin', $data);
					$this->load->view('damurid');
					$this->load->view('login/footerlogin');
				} else {
					//cek nama
					$nama_siswa = $this->input->post('nama');

					$siswa = $this->db->get_where('siswa', ['nama_siswa' => $nama_siswa])->row();
					if ($siswa) {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Nama sudah digunakan</div>');
						redirect('welcome/register');
					}
					$data_siswa = [
						'no_induk_siswa' => $this->input->post('no_induk_siswa'),
						'nama_siswa' => $this->input->post('nama'),
						'password' => $this->input->post('password'),
						'jenis_kelamin' => $this->input->post('jenis_kelamin'),
						'id_kelas' => $this->input->post('kelas'),
						'role' => 2,
						'date_created' => time(),
						'avatar' => 'default.jpg'

					];

					$this->db->insert('siswa', $data_siswa);
					$this->session->set_flashdata('message', '<div class= "alert alert-success" role="alert">Anda Sudah terdaftar . silahkan login </div>');
					redirect('welcome/murid');
				}
			}
			public function pelajaran()

			{
				$this->load->view('header');
				$this->load->view('pelajaran');
				$this->load->view('footer');
			}

			public function kontak()
			{
				$this->load->view('header');
				$this->load->view('kontak');
				$this->load->view('footer');
			}
			public function logout()
			{
				$this->session->unset_userdata('nama');
				$this->session->unset_userdata('password');
				$this->session->unset_userdata('id');
				$this->session->unset_userdata('role');
				$this->session->set_flashdata('pesan', "
				swal({
					title: 'Berhasil!',
					text: 'Anda Sudah Logout',
					type: 'success',
					padding: '2em'
					})
				");
				redirect('welcome');
			}
		}
