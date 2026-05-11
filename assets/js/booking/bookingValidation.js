export function validateCategoryId(category_idValue) {

    let errors = [];

    if (category_idValue === '') {
        errors.push('La categoría es obligatoria');
    }

    return errors;
}

export function validateRoomId(room_idValue) {

    let errors = [];

    if (room_idValue === '') {
        errors.push('La habitación es obligatoria');
    }

    return errors;
}

export function validateStartDate(start_dateValue) {

    let errors = [];

    if (start_dateValue === '') {
        errors.push('La fecha de inicio es obligatoria');
        return errors;
    }

    const today = new Date(start_dateValue);

    if (isNaN(today.getTime())) {
        errors.push('La fecha de inicio no es válida');
    }

    return errors;
}

export function validateEndDate(end_dateValue) {

    let errors = [];

    if (end_dateValue === '') {
        errors.push('La fecha de fin es obligatoria');
        return errors;
    }

    const today = new Date(end_dateValue);

    if (isNaN(today.getTime())) {
        errors.push('La fecha de fin no es válida');
    }

    return errors;
}

export function validateGuestCount(guest_countValue) {
    if(!fieldsTouched.guest_count) return [];
    let errors = [];
    const value = guest_countValue.trim();

    if (value === '') {
        errors.push('La cantidad de huéspedes es obligatoria');
        return errors;
    }

    if (isNaN(value)) {
        errors.push('Debe ser un numero valido');
    }

    if (parseInt(value) < 1 || parseInt(value) > 10) {
        errors.push('Debe ser entre 1 y 10');
    }

    return errors;
}

export function validatePaymentMethodId(payment_method_idValue) {


    let errors = [];

    if (payment_method_idValue === '') {
        errors.push('El método de pago es obligatorio');
    }

    return errors;
}

export function validateDateRange(start, end) {

    let errors = [];

    if (!start || !end) return [];

    const startDate = new Date(start);
    const endDate = new Date(end);

    if (startDate >= endDate) {
        errors.push('La fecha de inicio debe ser anterior a la fecha de fin');
    }

    return errors;
}

export function validateRequired(value, message) {
    return value ? [] : [message];
}