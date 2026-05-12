import ErrorHandler from "../utils/errorHandler.js";
import * as Validation from "./bookingValidation.js";
import * as Service from "./bookingServices.js";

const category_id = document.getElementById('category_id');
const room_id = document.getElementById('room_id');
const start_date = document.getElementById('start_date');
const end_date = document.getElementById('end_date');
const guest_count = document.getElementById('guest_count');
const payment_method_id = document.getElementById('payment_method_id');
const total_price = document.getElementById('total_price');
const save_button = document.getElementById('save_button');

let currentPrice = 0;
let currentMaxGuests = 0;

//------------------------------------------------------------------------------
// Estado de errores de los campos
const fieldsValidity = {
    category_id: false,
    room_id: false,
    start_date: false,
    end_date: false,
    guest_count: false,
    payment_method_id: false
}
//Estado de campos tocados
const fieldsTouched = {
    category_id: false,
    room_id: false,
    start_date: false,
    end_date: false,
    guest_count: false,
    payment_method_id: false
};

// Preparación de campos para el loop
const fieldsToValidate = [
    {
        element: category_id,
        event: "change",
        handler: handleValidateCategoryId,
        afterValidate: updateRooms
    },
    {
        element: room_id,
        event: "change",
        handler: handleValidateRoomId
    },
    {
        element: start_date,
        event: "change",
        handler: handleValidateStartDate
    },
    {
        element: end_date,
        event: "change",
        handler: handleValidateEndDate
    },
    {
        elements: [start_date, end_date],
        event: "change",
        handler: handleValidateDateRange
    },
    {
        element: guest_count,
        event: "change",
        handler: handleValidateGuestCount
    },
    {
        element: payment_method_id,
        event: "change",
        handler: handleValidatePaymentMethodId
    }
];

//------------------------------------------------------------------------------
//Validación de campos
function handleValidateCategoryId() {
    if(!fieldsTouched.category_id) return true;

    const errors = Validation.validateCategoryId(category_id.value);
    
    const validation = ErrorHandler.errorHandler(category_id, errors);

    return validation
}

function handleValidateRoomId() {
    if(!fieldsTouched.room_id) return true;

    const errors = Validation.validateRoomId(room_id.value);
    
    const validation = ErrorHandler.errorHandler(room_id, errors);

    return validation
}

function handleValidateStartDate() {
    if(!fieldsTouched.start_date) return true;

    const errors = Validation.validateStartDate(start_date.value);
    
    const validation = ErrorHandler.errorHandler(start_date, errors);

    return validation
}

function handleValidateEndDate() {
    if(!fieldsTouched.end_date) return true;

    const errors = Validation.validateEndDate(end_date.value);
    
    const validation = ErrorHandler.errorHandler(end_date, errors);

    return validation
}

function handleValidateDateRange() {
    if(!fieldsTouched.start_date || !fieldsTouched.end_date) return true;

    const errors = Validation.validateDateRange(start_date.value, end_date.value);

    ErrorHandler.errorHandler(start_date, errors);
    return ErrorHandler.errorHandler(end_date, errors);
}

function handleValidateGuestCount() {
    if(!fieldsTouched.guest_count) return true;
    
    const errors = Validation.validateGuestCount(guest_count.value);

    const validation = ErrorHandler.errorHandler(guest_count, errors);
    
    return validation
}

function handleValidatePaymentMethodId() {
    if(!fieldsTouched.payment_method_id) return true;

    const errors = Validation.validatePaymentMethodId(payment_method_id.value);

    const validation = ErrorHandler.errorHandler(payment_method_id, errors);

    return validation
}
//------------------------------------------------------------------------------
//Renderizado de habitaciones disponibles
function renderAvailableRooms(rooms) {

    room_id.innerHTML = '';

    if (rooms.length === 0) {
        room_id.innerHTML = '<option value="">No hay habitaciones disponibles</option>';
        room_id.disabled = true;
    } else {
        room_id.innerHTML = '<option value="">Seleccione una habitación</option>';
        rooms.forEach(room => {
            const option = document.createElement('option');
            option.value = room.id;
            option.textContent = room.number;
            room_id.appendChild(option);
        });
        room_id.disabled = false;
    }
}

async function updateRooms() {

    const rooms = await Service.fetchAvailableRooms(category_id.value)

    renderAvailableRooms(rooms)
}

//------------------------------------------------------------------------------
//Loop de validación
fieldsToValidate.forEach(field => {

    const elements = field.element
        ? [field.element]
        : field.elements;

    elements.forEach(el => {

        el.addEventListener(field.event, async () => {

            // touched
            elements.forEach(e => {
                fieldsTouched[e.id] = true;
            });

            const isValid = field.handler(); 

            fieldsValidity[field.element.id] = isValid;

            if (isValid && field.afterValidate) {
                await field.afterValidate()
            }

            save_button.disabled = ErrorHandler.isFormValid(fieldsToValidate);

        });

    });

});
