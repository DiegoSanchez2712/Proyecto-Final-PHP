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

    static errorHandler(input, errors) {
        if (errors.length > 0) {
            this.showErrorMessage(input, errors);
            return false
        }
        else {
            this.removeErrorMessage(input);
            return true
        }
    }

    static isFormValid(fieldsToValidate) {

        for (const field of fieldsToValidate) {

            const isValid = field.handler();

            if (!isValid) {
                return false;
            }

        }

        return true;

    }
}