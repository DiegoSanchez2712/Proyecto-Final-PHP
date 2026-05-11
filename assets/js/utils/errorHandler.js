export default class ErrorHandler {

    static showErrorMessage(input, errors) {

        let errorElement = this.removeErrorMessage(input);

        errors.forEach(error => {
            const errorMessage = document.createElement('div');

            errorMessage.classList.add('error-message');
            errorMessage.textContent = error;

            errorElement.appendChild(errorMessage);
        });
    }

    static removeErrorMessage(input) {

        let errorElement = input.parentElement;

        errorElement.querySelectorAll('.error-message').forEach(e => e.remove());

        return input.parentElement;
    }

    static isFormValid(fieldsToValidate) {
    let allValid = true
    fieldsToValidate.forEach(field => {
        const errors = field.handler()
        if (errors.length > 0) {
            allValid = false
        }
    })

    return !allValid
}
}