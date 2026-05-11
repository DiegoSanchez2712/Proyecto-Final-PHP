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
        handler: handleValidateCategoryId
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
async function handleValidateCategoryId() {
    if(!fieldsTouched.category_id) return [];

    const errors = Validation.validateCategoryId(category_id.value);
    
    if (errors.length > 0) {
        ErrorHandler.showErrorMessage(category_id, errors);
    }
    else {
        ErrorHandler.removeErrorMessage(category_id);
    }

    const rooms = await Service.fetchAvailableRooms(category_id.value);

    renderAvailableRooms(rooms);
}

function handleValidateRoomId() {
    if(!fieldsTouched.room_id) return [];

    const errors = Validation.validateRoomId(room_id.value);
    
    if (errors.length > 0) {
        ErrorHandler.showErrorMessage(room_id, errors);
    }
    else {
        ErrorHandler.removeErrorMessage(room_id);
    }
}

function handleValidateStartDate() {
    if(!fieldsTouched.start_date) return [];

    const errors = Validation.validateStartDate(start_date.value);
}

function handleValidateEndDate() {
    if(!fieldsTouched.end_date) return [];

    const errors = Validation.validateEndDate(end_date.value);
    
}

function handleValidateDateRange() {
    if(!fieldsTouched.start_date || !fieldsTouched.end_date) return [];

    const errors = Validation.validateDateRange(start_date.value, end_date.value);
}

function handleValidateGuestCount() {
    if(!fieldsTouched.guest_count) return [];
    
    const errors = Validation.validateGuestCount(guest_count.value);
}

function handleValidatePaymentMethodId() {
    if(!fieldsTouched.payment_method_id) return [];

    const errors = Validation.validatePaymentMethodId(payment_method_id.value);
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

//------------------------------------------------------------------------------
//Loop de validación
fieldsToValidate.forEach(field => {

    const elements = field.element
        ? [field.element]
        : field.elements;

    elements.forEach(el => {

        el.addEventListener(field.event, () => {

            // touched
            elements.forEach(e => {
                fieldsTouched[e.id] = true;
            });

            const errors = field.handler();

            if (errors.length > 0) {
                ErrorHandler.showErrorMessage(el, errors);
            }

            else {
                ErrorHandler.removeErrorMessage(el);
            }
            

            save_button.disabled = ErrorHandler.isFormValid(fieldsToValidate);

        });

    });

});
