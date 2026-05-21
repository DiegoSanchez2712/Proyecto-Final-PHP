import ErrorHandler from "../utils/errorHandler.js";
import * as Validation from "./bookingValidation.js";
import * as Service from "./bookingServices.js";

//----------------------------------------------------
// ELEMENTOS
//----------------------------------------------------
const form = document.getElementById('form');

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
// ESTADO
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

        room_id.innerHTML = '<option value="">Seleccione un tipo de habitación</option>';
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

function resetRoomState() {

    currentPrice = 0;
    currentMaxGuests = 0;

    room_id.value = "";
    guest_count.value = "";

    guest_count.disabled = true;

    guest_limit.textContent = "Seleccione una habitación";

    renderTotalPrice();
}

function updateRoomPricing(room) {
    console.log("ROOM:", room);
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

    resetRoomState();
}

async function updateGuestCountAndPrice() {

    if (!room_id.value) {

        updateRoomPricing(null);

        return;
    }

    console.log(room_id.value)

    const room = await Service.fetchGuestCountAndPrice(room_id.value);

    console.log(room);

    updateRoomPricing(room);
}

//----------------------------------------------------
// VALIDATE FORM
//----------------------------------------------------
function validateForm() {

    const validations = [
        handleValidateCategoryId(),
        handleValidateRoomId(),
        handleValidateStartDate(),
        handleValidateEndDate(),
        handleValidateDateRange(),
        handleValidateGuestCount(),
        handleValidatePaymentMethodId()
    ];

    save_button.disabled = validations.includes(false);
}

//----------------------------------------------------
// LISTENERS
//----------------------------------------------------
category_id.addEventListener('change', async () => {

    fieldsTouched.category_id = true;

    handleValidateCategoryId();

    await updateRooms();

    validateForm();
});

room_id.addEventListener('change', async () => {

    fieldsTouched.room_id = true;

    handleValidateRoomId();

    await updateGuestCountAndPrice();

    renderTotalPrice();

    validateForm();
});

start_date.addEventListener('change', () => {

    fieldsTouched.start_date = true;

    handleValidateStartDate();
    handleValidateDateRange();

    renderTotalPrice();

    validateForm();
});

end_date.addEventListener('change', () => {

    fieldsTouched.end_date = true;

    handleValidateEndDate();
    handleValidateDateRange();

    renderTotalPrice();

    validateForm();
});

guest_count.addEventListener('change', () => {

    fieldsTouched.guest_count = true;

    handleValidateGuestCount();

    validateForm();
});

payment_method_id.addEventListener('change', () => {

    fieldsTouched.payment_method_id = true;

    handleValidatePaymentMethodId();

    validateForm();
});

//----------------------------------------------------
// UPDATE MODE
//----------------------------------------------------
async function initializeUpdate() {

    if (form.dataset.mode !== 'update') return;

    Object.keys(fieldsTouched).forEach(key => {
        fieldsTouched[key] = true;
    });

    await updateGuestCountAndPrice();

    handleValidateDateRange();

    renderTotalPrice();

    validateForm();
}

initializeUpdate();