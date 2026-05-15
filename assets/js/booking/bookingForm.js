import ErrorHandler from "../utils/errorHandler.js";
import * as Validation from "./bookingValidation.js";
import * as Service from "./bookingServices.js";

//----------------------------------------------------
// ELEMENTOS
//----------------------------------------------------
const category_id = document.getElementById('category_id');
const room_id = document.getElementById('room_id');
const start_date = document.getElementById('start_date');
const end_date = document.getElementById('end_date');
const date_range = document.getElementById('date_range');
const guest_count = document.getElementById('guest_count');
const guest_limit = document.getElementById('guest_limit');
const payment_method_id = document.getElementById('payment_method_id');
const total_price = document.getElementById('total_price');
const save_button = document.getElementById('save_button');

//----------------------------------------------------
// ESTADO MÍNIMO REAL
//----------------------------------------------------
let currentPrice = 0;
let currentMaxGuests = 0;

//----------------------------------------------------
// TOUCH STATE
//----------------------------------------------------
const fieldsTouched = {
    category_id: false,
    room_id: false,
    start_date: false,
    end_date: false,
    guest_count: false,
    payment_method_id: false
};

//----------------------------------------------------
// VALIDACIONES
//----------------------------------------------------
function handleValidateCategoryId() {
    if (!fieldsTouched.category_id) return false;
    const errors = Validation.validateCategoryId(category_id.value);
    return ErrorHandler.errorHandler(category_id, errors);
}

function handleValidateRoomId() {
    if (!fieldsTouched.room_id) return false;
    const errors = Validation.validateRoomId(room_id.value);
    return ErrorHandler.errorHandler(room_id, errors);
}

function handleValidateStartDate() {
    if (!fieldsTouched.start_date) return false;
    const errors = Validation.validateStartDate(start_date.value);
    return ErrorHandler.errorHandler(start_date, errors);
}

function handleValidateEndDate() {
    if (!fieldsTouched.end_date) return false;
    const errors = Validation.validateEndDate(end_date.value);
    return ErrorHandler.errorHandler(end_date, errors);
}

function handleValidateDateRange() {
    if (!fieldsTouched.start_date || !fieldsTouched.end_date) return false;

    const errors = Validation.validateDateRange(
        start_date.value,
        end_date.value
    );

    return ErrorHandler.errorHandler(date_range, errors);
}

function handleValidateGuestCount() {
    if (!fieldsTouched.guest_count) return false;

    const errors = Validation.validateGuestCount(guest_count.value);
    return ErrorHandler.errorHandler(guest_count, errors);
}

function handleValidatePaymentMethodId() {
    if (!fieldsTouched.payment_method_id) return false;

    const errors = Validation.validatePaymentMethodId(payment_method_id.value);
    return ErrorHandler.errorHandler(payment_method_id, errors);
}

//----------------------------------------------------
// ROOM LOGIC
//----------------------------------------------------
function renderAvailableRooms(rooms) {

    room_id.innerHTML = '';

    if (!category_id.value) {
        room_id.innerHTML = '<option value="">Seleccione un tipo de habitacion</option>';
        room_id.disabled = true;
        return;
    }

    if (!rooms.length) {
        room_id.innerHTML = '<option value="">No hay habitaciones disponibles</option>';
        room_id.disabled = true;
        return;
    }

    room_id.innerHTML = '<option value="">Seleccione una habitación</option>';

    rooms.forEach(room => {
        const option = document.createElement('option');
        option.value = room.id;
        option.textContent = room.number;
        room_id.appendChild(option);
    });

    room_id.disabled = false;
}

function updateRoomPricing(room) {

    if (!room) {
        currentPrice = 0;
        currentMaxGuests = 0;
        guest_count.disabled = true;
        renderTotalPrice();
        return;
    }

    currentPrice = room.price;
    currentMaxGuests = room.guestCount;

    guest_limit.textContent = `El límite de huéspedes es ${currentMaxGuests}`;
    guest_count.max = currentMaxGuests;
    guest_count.disabled = false;

    renderTotalPrice();
}

//----------------------------------------------------
// TOTAL PRICE 
//----------------------------------------------------
function calculateDays() {

    if (!start_date.value || !end_date.value) return 0;

    const start = new Date(start_date.value);
    const end = new Date(end_date.value);

    start.setHours(0, 0, 0, 0);
    end.setHours(0, 0, 0, 0);

    const diff = (end - start) / (1000 * 60 * 60 * 24);

    return diff > 0 ? diff : 0;
}

function renderTotalPrice() {

    const days = calculateDays();

    if (!days || !currentPrice) {
        total_price.textContent = "$0";
        return;
    }

    const total = days * currentPrice;

    total_price.textContent = `$${total.toLocaleString()}`;
}

//----------------------------------------------------
// SERVICES
//----------------------------------------------------
async function updateRooms() {

    const rooms = await Service.fetchAvailableRooms(category_id.value);

    renderAvailableRooms(rooms);

    if (!category_id.value || rooms.length === 0) {

        currentPrice = 0;
        currentMaxGuests = 0;

        room_id.value = "";
        guest_count.value = "";
        guest_count.disabled = true;

        guest_limit.textContent = "Seleccione una habitación";
        total_price.textContent = "$0";

        renderTotalPrice();

        return;
    }

    room_id.value = "";
    currentPrice = 0;
    currentMaxGuests = 0;

    guest_count.value = "";
    guest_count.disabled = true;

    guest_limit.textContent = "Seleccione una habitación";
    total_price.textContent = "$0";
}

async function updateGuestCountAndPrice() {
    const room = await Service.fetchGuestCountAndPrice(room_id.value);
    updateRoomPricing(room);
}

//----------------------------------------------------
// EVENT LOOP (ORQUESTADOR)
//----------------------------------------------------
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
        handler: handleValidateRoomId,
        afterValidate: updateGuestCountAndPrice
    },
    {
        element: start_date,
        event: "change",
        handler: handleValidateStartDate,
        afterValidate: handleValidateDateRange
    },
    {
        element: end_date,
        event: "change",
        handler: handleValidateEndDate,
        afterValidate: handleValidateDateRange
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

fieldsToValidate.forEach(field => {

    const elements = [field.element];

    elements.forEach(el => {

        el.addEventListener(field.event, async () => {

            fieldsTouched[el.id] = true;

            const isValid = field.handler();

            field.valid = isValid;

            if (field.afterValidate) {
                await field.afterValidate();
            }

            renderTotalPrice();

            save_button.disabled = !fieldsToValidate.every(f => f.valid);
        });
    });
});