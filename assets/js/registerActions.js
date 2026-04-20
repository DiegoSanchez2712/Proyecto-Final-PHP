const document_type_id = document.getElementById('document_type_id');
const document_number = document.getElementById('document_number');
const name = document.getElementById('name');
const last_name = document.getElementById('last_name');
const phone = document.getElementById('phone');
const email = document.getElementById('email');
const password = document.getElementById('password');
const submitButton = document.getElementById('submitButton');
const fieldstouched = {
    document_type_id: false,
    document_number: false,
    name: false,
    last_name: false,
    phone: false,
    email: false,
    password: false
}
//Preparación de campos para el loop
const fieldsToValidate = [
    {
        element: document_type_id,
        event: "change",
        validate: validateDocument_type_id
    },
    {
        element: document_number,
        event: "input",
        validate: validateDocument_number
    },
    {
        element: name,
        event: "input",
        validate: validateName
    },
    {
        element: last_name,
        event: "input",
        validate: validateLastName
    },
    {
        element: phone,
        event: "input",
        validate: validatePhone
    },
    {
        element: email,
        event: "input",
        validate: validateEmail
    },
    {
        element: password,
        event: "input",
        validate: validatePassword
    }
]

// ------------------------------------------------------------------------------
//Manejo de errores
function showErrorMessage(input, errors) {
    let errorElement = input.parentElement;
    errorElement.querySelectorAll('.error-message').forEach(e => e.remove());

    errors.forEach(error => {
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('error-message');
        errorMessage.textContent = error;
        errorElement.appendChild(errorMessage);
    });
}

function removeErrorMessage(input) {
    let errorElement = input.parentElement;
    errorElement.querySelectorAll('.error-message').forEach(e => e.remove());
}

// ------------------------------------------------------------------------------
//Validación de campos

function validateDocument_type_id() { 
    if (!fieldstouched[document_type_id.id]) return []

    let errors = []

    if (document_type_id.value === '') {
        errors.push('Por favor, selecciona un tipo de documento.')
    }

    return errors
}

function validateDocument_number() {
    if (!fieldstouched[document_number.id]) return []

    let errors = []
    const value = document_number.value.trim()

    if (value === '') {
        errors.push('El número de documento es obligatorio.')
        return errors
    }

    if (!/^\d+$/.test(value)) {
        errors.push('Debe ser numérico.')
    }

    if (value.length < 6 || value.length > 12) {
        errors.push('Debe tener entre 6 y 12 dígitos.')
    }

    return errors
}

function validateName() {
    if (!fieldstouched[name.id]) return []

    let errors = []
    const value = name.value.trim()

    if (value === '') {
        errors.push('El nombre es obligatorio.')
        return errors
    }

    if (!/^[a-zA-Z\s]+$/.test(value)) {
        errors.push('Solo letras y espacios.')
    }

    if (value.length < 2 || value.length > 50) {
        errors.push('Entre 2 y 50 caracteres.')
    }

    return errors
}

function validateLastName() {
    if (!fieldstouched[last_name.id]) return []

    let errors = []
    const value = last_name.value.trim()

    if (value === '') {
        errors.push('El apellido es obligatorio.')
        return errors
    }

    if (!/^[a-zA-Z\s]+$/.test(value)) {
        errors.push('Solo letras y espacios.')
    }

    if (value.length < 2 || value.length > 50) {
        errors.push('Entre 2 y 50 caracteres.')
    }

    return errors
}

function validatePhone() {
    if (!fieldstouched[phone.id]) return []

    let errors = []
    const value = phone.value.trim()

    if (value === '') {
        errors.push('El teléfono es obligatorio.')
        return errors
    }

    if (!/^\d+$/.test(value)) {
        errors.push('Debe ser numérico.')
    }

    if (value.length < 8 || value.length > 15) {
        errors.push('Debe tener entre 8 y 15 dígitos.')
    }

    return errors
}

function validateEmail() {
    if (!fieldstouched[email.id]) return []

    let errors = []
    const value = email.value.trim()

    if (value === '') {
        errors.push('El correo es obligatorio.')
        return errors
    }

    if (!/^\S+@\S+\.\S+$/.test(value)) {
        errors.push('Correo no válido.')
    }

    return errors
}

function validatePassword() {
    if (!fieldstouched[password.id]) return []

    let errors = []
    const value = password.value.trim()

    if (value === '') {
        errors.push('La contraseña es obligatoria.')
        return errors
    }

    if (!/[A-Z]/.test(value)) {
        errors.push("Falta mayúscula")
    }

    if (!/[a-z]/.test(value)) {
        errors.push("Falta minúscula")
    }

    if (!/[0-9]/.test(value)) {
        errors.push("Falta número")
    }

    if (!/[^A-Za-z0-9]/.test(value)) {
        errors.push("Falta carácter especial")
    }

    if (value.length < 6 || value.length > 20) {
        errors.push('Entre 6 y 20 caracteres')
    }

    return errors
}

function validateForm() {
    let allValid = true
    fieldsToValidate.forEach(field => {
        const errors = field.validate()
        if (errors.length > 0) {
            allValid = false
        }
    })

    submitButton.disabled = !allValid
}


// ------------------------------------------------------------------------------


fieldsToValidate.forEach(field => {
    field.element.addEventListener(field.event, () => {
        fieldstouched[field.element.id] = true

        const errors = field.validate()

        if (errors.length > 0) {
            showErrorMessage(field.element, errors)
        } else {
            removeErrorMessage(field.element)
        }

        validateForm()
    })
})

