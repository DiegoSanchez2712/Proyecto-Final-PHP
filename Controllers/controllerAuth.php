<?php 
require_once 'controllerBase.php';
class ControllerAuth extends ControllerBase { 

    public function validateRegisterData($data) {
        $errors = [];

        // Validacion de docuement_type_id
        if (!empty($data['document_type_id'])) {
            if (!in_array($data['document_type_id'], [1, 2, 3])) {
                $errors['document_type_id'][] = 'El tipo de documento no es válido';
            }
        }
        else {
            $errors['document_type_id'][] = 'El tipo de documento es obligatorio';
        }

        // Validacion de document_number
        if (!empty($data['document_number'])) {
            if (!is_numeric($data['document_number'])) {
                $errors['document_number'][] = 'El número de documento debe ser numérico';
            }
        }
        else {
            $errors['document_number'][] = 'El número de documento es obligatorio';
        }

        // Validacion de name
        if (empty($data['name'])) {
            $errors['name'][] = 'El nombre es obligatorio';
        }

        // Validacion de last_name
        if (empty($data['last_name'])) {
            $errors['last_name'][] = 'El apellido es obligatorio';
        }

        // Validacion de phone
        if (!empty($data['phone'])) {
            if (!is_numeric($data['phone'])) {
                $errors['phone'][] = 'El teléfono debe ser numérico';
            }
        }
        else {
            $errors['phone'][] = 'El teléfono es obligatorio';
        }

        // Validacion de email
        if (empty($data['email'])) {
            $errors['email'][] = 'El email es obligatorio';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'El email no es válido';
        }

        // Validacion de password
        if (empty($data['password'])) {
            $errors['password'][] = 'La contraseña es obligatoria';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $data['password'])) {
            $errors['password'][] = 'La contraseña debe tener al menos 6 caracteres, una mayuscula, una minuscula, un numero y un caracter especial';
        }
        return $errors;
    }
    public function validateLoginData($data) {
        $errors = [];
        $user = new User();
        if (empty($data['email'])) {
            $errors['email'][] = 'El email es obligatorio';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'El email no es válido';
        }
        if (empty($data['password'])) {
            $errors['password'][] = 'La contraseña es obligatoria';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return $errors;
    }

    private function loginFailed($datos) {
        $_SESSION['errors']['general'][] = 'Credenciales incorrectas';
        $_SESSION['old'] = $datos;
        
        $this->redirect(SITE_URL . 'index.php?action=getFormLoginUser');
    }

    public function registerUser($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);
        
        $errores = $this->validateRegisterData($datos);

        $user = new User();

        if (empty($errores)) {

            if ($user->emailExists($datos['email'])) {
                $errores['email'][] = 'El email ya existe';
            }

            if ($user->documentNumberExists($datos['document_number'])) {
                $errores['document_number'][] = 'El número de documento ya existe';
            }
        }
        

        if (!empty($errores)) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            
            $this->redirect(SITE_URL . 'index.php?action=getFormRegisterUser');
        }

        $password = password_hash($datos['password'], PASSWORD_DEFAULT);
        $datos['password'] = $password;

        $resultado = $user->createUser($datos);
        if ($resultado === true) {
            $_SESSION['success'] = 'Usuario registrado exitosamente';
            $this->redirect(SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => 'Error al registrar el usuario'];
            $_SESSION['old'] = $datos;
            
            $this->redirect(SITE_URL . 'index.php?action=getFormRegisterUser');
        }
    } 

    public function loginUser($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);
        
        $errores = $this->validateLoginData($datos);
        if (!empty($errores)) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            
            $this->redirect(SITE_URL . 'index.php?action=getFormLoginUser');
        } 

        $user = new User();
        $existe = $user->getUserByEmail($datos['email']);

        if ($existe === null) {
            $this->loginFailed($datos);
        }

        if (!password_verify($datos['password'], $existe['password'])) {
            $this->loginFailed($datos);
        }

        $_SESSION['user'] = [
            'id' => $existe['id'],
            'name' => $existe['name'],
            'email' => $existe['email']
        ];

        $this->redirect(SITE_URL . 'index.php?action=getDashboard');
    }
}
