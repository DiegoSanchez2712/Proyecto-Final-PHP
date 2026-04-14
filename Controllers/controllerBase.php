<?php
class ControllerBase {

    public function verPaginaInicio($pagina) {
        include_once $pagina;
    }

    public function validateRegisterData($data) {
        $errors = [
            "document_type_id" => [],
            "document_number" => [],
            "name" => [],
            "last_name" => [],
            "phone" => [],
            "email" => [],
            "password" => []
        ];

        // Validacion de docuement_type_id
        if (!empty($data['document_type_id'])) {
            if (!in_array($data['document_type_id'], [1, 2, 3])) {
                $errors['document_type_id'][] = 'El tipo de documento no es válido';
            }
        }
        else {
            $errors['document_type_id'] = 'El tipo de documento es obligatorio';
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
        } elseif (strlen($data['password']) < 6) {
            $errors['password'][] = 'La contraseña debe tener al menos 6 caracteres';
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

        $existe = $user->validateRegisterUser($data);
        if ($existe == 0) {
            $errors['general'][] = 'El usuario no existe';
        }
        return $errors;
    }

    public function registerUser($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);
        
        $errores = $this->validateRegisterData($datos);
        var_dump($errores);
        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            
            header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
            exit;
        } 

        $user = new User();
        $existe = $user->validateRegisterUser($datos);
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
    public function loginUser($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);
        
        $errores = $this->validateLoginData($datos);
        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        } 

        $user = new User();
        $existe = $user->validateLoginUser($datos);
        if ($existe == 0) {
            $_SESSION['errors'] = ['general' => 'El usuario no existe'];
            $_SESSION['old'] = $datos;
            
            header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        
    }
}
?>