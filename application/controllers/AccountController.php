<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

	public function loginAction() {
		// debug($_POST);
		if (isset($_POST['login']) && isset($_POST['password'])) {
			debug($_POST);
		}
		$this->view->render('Вход');
	}

	public function registerAction() {
		if (isset($_POST['login']) && isset($_POST['password'])) {
			debug($_POST);
		}
		$this->view->render('Регистрация');
	}

}