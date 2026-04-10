<?php
class ControllerBase {
    protected $view;

    public function verPaginaInicio($pagina) {
        include_once $pagina;
    }

    public function validateData($data) {
        $errors = [];
        if (empty($data['document_type_id'])) {
            $errors['document_type_id'] = 'El tipo de documento es obligatorio';
            if (!in_array($data['document_type_id'], [1, 2, 3])) {
                $errors['document_type_id'] = 'El tipo de documento no es válido';
            }
        }
        if (empty($data['document_number'])) {
            $errors['document_number'] = 'El número de documento es obligatorio';
        }
        if (empty($data['name'])) {
            $errors['name'] = 'El nombre es obligatorio';
        }
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'El apellido es obligatorio';
        }
        if (empty($data['phone'])) {
            $errors['phone'] = 'El teléfono es obligatorio';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'El email es obligatorio';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El email no es válido';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'La contraseña es obligatoria';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'La contraseña debe tener al menos 6 caracteres';
        }
        return $errors;
    }

    public function registerUser($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);
        
        $errores = $this->validateData($datos);
        var_dump($errores);
        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        } 

        $user = new User();
        $existe = $user->validateUser($datos);
        if ($existe>0) {
            $_SESSION['errors'] = ['general' => 'El usuario ya existe'];
            $_SESSION['old'] = $datos;
            
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }

        $password = password_hash($datos['password'], PASSWORD_DEFAULT);
        $datos['password'] = $password;

        $resultado = $user->registerUser($datos);
        if ($resultado > 0) {
            $_SESSION['success'] = 'Usuario registrado exitosamente';
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => 'Error al registrar el usuario'];
            $_SESSION['old'] = $datos;
            
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        }
    } 
}
?>