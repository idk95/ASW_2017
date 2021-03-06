<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set("Europe/Lisbon");
		$this->load->model('user_model');
		$this->load->library('email');
		$this->load->library('upload');

	}

	public function register()
	{
		$validator = array('success' => false, 'messages' => array());

		$config = array(
	        array(
	                'field' => 'name',
	                'label' => 'User First Name',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'surname',
	                'label' => 'User Last Name',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'username',
	                'label' => 'User username',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'email',
	                'label' => 'User email',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'password',
	                'label' => 'User password',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'birthDate',
	                'label' => 'User birth date',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'sexo',
	                'label' => 'User sex',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'country',
	                'label' => 'User country',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'dist',
	                'label' => 'User district if in Portugal',
	                'rules' => 'trim|integer|strip_tags',
	        ),
	        array(
	                'field' => 'con',
	                'label' => 'User county if in Portugal',
	                'rules' => 'trim|integer|strip_tags',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$createUser = $this->user_model->registerUser();
			if($createUser === true){
				$validator['success']  = true;
				$validator['messages'] = 'Adicionado com sucesso';

				$this->email->from('support@pokeronline.com', 'Poker Online');
				$this->email->to($this->input->post('email'));

				$this->email->subject('Confirmação de email');
				$this->email->message("<p>Para terminar o seu registo por favor clique no link abaixo para confirmar o seu e-mail</p>
										<a href='http://appserver-01.alunos.di.fc.ul.pt/~asw004/projeto/index.php/user/confemail'>http://appserver-01.alunos.di.fc.ul.pt/~asw004/projeto/index.php/user/confemail</a>");

				// if ( ! $this->email->send()){
    //     			$validator['messages'].="<br>Email n&atilde;o enviado";
				// }

			}else{
				$validator['success']  = false;
				$validator['messages'] = 'Erro ao atualizar a base de dados';
			}
		} else{
			$validator['success']  = false;
			$validator['messages'] = 'Erro a validar a informa&ccedil;&atilde;o';
		}

		echo json_encode($validator);
	}

	public function update()
	{
		$validator = array('success' => false, 'messages' => array());

		$config = array(
	        array(
	                'field' => 'name',
	                'label' => 'User First Name',
	                'rules' => 'trim|required|strip_tags'
	        ),
	        array(
	                'field' => 'surname',
	                'label' => 'User Last Name',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'username',
	                'label' => 'User username',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'email',
	                'label' => 'User email',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'birthDate',
	                'label' => 'User birth date',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'sex',
	                'label' => 'User sex',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'country',
	                'label' => 'User country',
	                'rules' => 'trim|required|strip_tags',
	        ),
	        array(
	                'field' => 'district',
	                'label' => 'User district if in Portugal',
	                'rules' => 'trim|integer|strip_tags',
	        ),
	        array(
	                'field' => 'county',
	                'label' => 'User county if in Portugal',
	                'rules' => 'trim|integer|strip_tags',
	        ),
	        array(
	                'field' => 'avatar',
	                'label' => 'user profile image',
	                'rules' => 'trim',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			if(isset($_FILES['avatar'])){
				// $validator['success']  = true;
				// $validator['messages'] = 'Atualizado com sucesso';
				$target_file   = basename($_FILES["avatar"]["name"]);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$imageName     = MD5($this->input->post('username')).'.'.$imageFileType;
				$image         = $this->updateUserAvatar($imageName);
				if($image['success']){
					$user = $this->user_model->updateUser($imageName);
					if($user === true){
						$validator['success']  = true;
						$validator['messages'] = 'Atualizado com sucesso';
					}else{
						$validator['success']  = false;
						$validator['messages'] = 'Erro ao atualizar a base de dados<br>'.$user;
					}
				}else{
					$validator['success']  = false;
					$validator['messages'] = $image['messages']."<br>".$imageName;
				}
			}else{
				$user = $this->user_model->updateUser();
				if($user === true){
					$validator['success']  = true;
					$validator['messages'] = 'Atualizado com sucesso';
				}else{
					$validator['success']  = false;
					$validator['messages'] = 'Erro ao atualizar a base de dados';
				}
			}

		} else{
			$validator['success']  = false;
			$validator['messages'] = 'Erro a validar a informação';
		}
		echo json_encode($validator);
	}

	public function changePassword()
	{
		$validator = array('success' => false, 'messages' => array());

		$config = array(
	        array(
	                'field' => 'passNew',
	                'label' => 'User password',
	                'rules' => 'trim|required',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$chageUserPassword = $this->user_model->chageUserPassword($this->session->userdata['loggedIn_asw004']['username']);
			if($chageUserPassword === true){
				$validator['success']  = true;
				$validator['messages'] = 'Atualizado com sucesso';

			}else{
				$validator['success']  = false;
				$validator['messages'] = 'Erro ao atualizar a base de dados<br>'.$chageUserPassword;
			}
		} else{
			$validator['success']  = false;
			$validator['messages'] = 'Erro a validar a informa&ccedil;&atilde;o';
		}

		echo json_encode($validator);
	}

	public function updateBalance()
	{
		$validator = array('success' => false, 'messages' => array());

		$config = array(
	        array(
	                'field' => 'balanceCharge',
	                'label' => 'User balance to charge',
	                'rules' => 'trim|required|numeric|strip_tags',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$result = $this->user_model->updateUserBalance($this->session->userdata['loggedIn_asw004']['username']);
			if($result === true){
				$validator['success']  = true;
				$validator['messages'] = 'Atualizado com sucesso';

			}else{
				$validator['success']  = false;
				$validator['messages'] = 'Erro ao atualizar a base de dados<br>'.$result;
			}
		} else{
			$validator['success']  = false;
			$validator['messages'] = 'Erro a validar a informa&ccedil;&atilde;o';
		}

		echo json_encode($validator);
	}

	public function deleteUser()
	{
		$validator = array('success' => false, 'messages' => array());

		$config = array(
	        array(
	                'field' => 'username',
	                'label' => 'User username',
	                'rules' => 'trim|required|strip_tags',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$result = $this->user_model->deleteUser();
			if($result === true){
				$validator['success']  = true;
				$validator['messages'] = 'Utilizador apagado com sucesso';

			}else{
				$validator['success']  = false;
				$validator['messages'] = 'Erro ao atualizar a base de dados<br>';
			}
		} else{
			$validator['success']  = false;
			$validator['messages'] = 'Erro a validar a informa&ccedil;&atilde;o';
		}

		echo json_encode($validator);
	}

	public function login()
	{
		$validator = array('success' => false, 'messages' => array());

		$config = array(
	        array(
	                'field' => 'username',
	                'label' => 'User username',
	                'rules' => 'trim|required',
	        ),
	        array(
	                'field' => 'password',
	                'label' => 'User password',
	                'rules' => 'trim|required',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$loginResult = $this->user_model->loginUser_post();
			if($loginResult['success'] === true){
				$validator['success']  = true;
				$validator['messages'] = 'Utilizador autentificado com sucesso';

				$session_data = array(
						'id'		=> $loginResult['messages']['id'],
				        'username'  => $loginResult['messages']['username'],
				        'email'     => $loginResult['messages']['email'],
				        'level'     => $loginResult['messages']['level'],
				        'logged_in' => TRUE
				);
				$this->session->set_userdata('loggedIn_asw004', $session_data);
			}else{
				$validator['success']  = false;
				$validator['messages'] = $loginResult['messages'];
			}
		} else{
			$validator['success']  = false;
			$validator['messages'] = 'Erro a validar a informação';
		}

		echo json_encode($validator);
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('/', 'refresh');
	}

	public function getUserDetails()
	{
		$validator = array('success' => false, 'messages' => array());

		$config = array(
	        array(
	                'field' => 'id',
	                'label' => 'User usernme',
	                'rules' => 'trim|required',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$result = $this->user_model->getUserDetails();
			if($result['success'] === true){
				$validator['success']  = true;
				$validator['messages'] = $result['data'];

			}else{
				$validator['success']  = false;
				$validator['messages'] = 'Utilizador não encontrado<br>'.$result['data'];
			}
		} else{
			$validator['success']  = false;
			$validator['messages'] = 'Erro a validar a informa&ccedil;&atilde;o';
		}

		echo json_encode($validator);
	}

	public function getUserDataAdmin($dateB, $dateE, $district, $county)
	{
		$outputData = array('data' => array());

		$result = $this->user_model->getUserDataAdmin();
		foreach ($result as $row) {
			if ($this->getUsersByAdv($dateB, $dateE, $district, $county, $row['username'])){
				$data = [
					$row['fName'],
					$row['lName'],
					"<span class='username-table text-primary details-user' data-toggle='modal' data-userId='".$row['username']."' data-target='#userDetails'>".$row['username']."</span>",
					$row['email'],
					number_format($row['balance'], 2, ',', ' ')." €",
					$row['birthDate'],
					$row['country'],
					"<button type='button' class='btn btn-info details-user' data-toggle='modal' data-userId='".$row['username']."' data-target='#userDetails'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>
					 <button type='button' class='btn btn-danger delete-user' data-userId='".$row['username']."'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>"
				];
				array_push($outputData['data'], $data);
			}
		}
		echo json_encode($outputData);
	}

	public function getUsersByAdv($dateB, $dateE, $district, $county, $user)
	{
		if ($dateB == 'NULL' && $dateE == 'NULL' && $district == 'NULL' && $county == 'NULL'){
			return true;
		}

		return $this->user_model->getDateAndDistrict($dateB, $dateE, $district, $county, $user);


	}

	public function checkEmail()
	{

		$validator = array('success' => false, 'exists' => false);

		$config = array(
	        array(
	                'field' => 'email',
	                'label' => 'User email',
	                'rules' => 'trim|required',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$result = $this->user_model->checkEmail();
			if($result === true){
				$validator['success']  = true;
				$validator['exists']   = true;
			}else{
				$validator['success']  = true;
				$validator['exists']   = false;
			}
		} else{
			$validator['success']  = false;
			$validator['exists']   = 'Erro a validar a info recebida!';
		}

		echo json_encode($validator);
	}

	public function checkUsername()
	{

		$validator = array('success' => false, 'exists' => false);

		$config = array(
	        array(
	                'field' => 'username',
	                'label' => 'User username',
	                'rules' => 'trim|required',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$result = $this->user_model->checkUsername();
			if($result === true){
				$validator['success']  = true;
				$validator['exists']   = true;
			}else{
				$validator['success']  = true;
				$validator['exists']   = false;
			}
		} else{
			$validator['success']  = false;
			$validator['exists']   = 'Erro a validar a info recebida!';
		}

		echo json_encode($validator);
	}

	public function checkOldPassword()
	{

		$validator = array('success' => false, 'exists' => false);

		$config = array(
	        array(
	                'field' => 'password',
	                'label' => 'User password',
	                'rules' => 'trim|required',
	        ),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true){
			$result = $this->user_model->checkUserPassword($this->session->userdata['loggedIn_asw004']['username']);
			$validator['success']  = true;
			$validator['exists']   = $result;
		} else{
			$validator['success']  = false;
			$validator['exists']   = 'Erro a validar a info recebida!';
		}

		echo json_encode($validator);
	}

	public function checksessionintegraty()
	{
		$sessionCheckResult = false;
		if ( isset($this->session->userdata['loggedIn_asw004']) ){
			if($this->session->userdata['loggedIn_asw004']['logged_in']){
				$sessionCheckResult = true;
			}
		}
		echo json_encode($sessionCheckResult);
	}

	public function updateUserAvatar($filename)
	{
		$validator = array('success' => false, 'messages' => array());

		$config['upload_path']   = 'custom/images/users/profilePics/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name']     = $filename;
		$config['overwrite']     = TRUE;
		$config['max_size']      = '100';

		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload('avatar')){
			$validator['success']  = false;
			$validator['messages'] = $this->upload->display_errors('', '');
			return $validator;
		}else{
			$validator['success']  = true;
			$validator['messages'] = $this->upload->data();
			return $validator;
		}
	}
}
