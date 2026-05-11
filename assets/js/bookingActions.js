import ErrorHandler from "./utils/errorHandler.js";

const category_id = document.getElementById('category_id');
const room_id = document.getElementById('room_id');
const start_date = document.getElementById('start_date');
const end_date = document.getElementById('end_date');
const guest_count = document.getElementById('guest_count');
const payment_method_id = document.getElementById('payment_method_id');
const total_price = document.getElementById('total_price');
const save_button = document.getElementById('save_button');
let currentGuestCount = 0;
let currentPrice = 0;
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
        validate: validateCategoryId
    },
    {
        element: room_id,
        event: "change",
        validate: validateRoomId
    },
    {
        element: start_date,
        event: "change",
        validate: validateStartDate
    },
    {
        element: end_date,
        event: "change",
        validate: validateEndDate
    },
    {
        elements: [start_date, end_date],
        event: "change",
        validate: validateDateRange
    },
    {
        element: guest_count,
        event: "change",
        validate: validateGuestCount
    },
    {
        element: payment_method_id,
        event: "change",
        validate: validatePaymentMethodId
    }
];

//------------------------------------------------------------------------------
//Validación de campos
function validateCategoryId() {
    if(!fieldsTouched.category_id) return [];

    let errors = [];

    if (category_id.value === '') {
        errors.push('La categoría es obligatoria');
    }

    return errors;
}

function validateRoomId() {
    if(!fieldsTouched.room_id) return [];

    let errors = [];

    if (room_id.value === '') {
        errors.push('La habitación es obligatoria');
    }

    return errors;
}

function validateStartDate() {
    if(!fieldsTouched.start_date) return [];

    let errors = [];

    if (start_date.value === '') {
        errors.push('La fecha de inicio es obligatoria');
        return errors;
    }
    console.log(start_date.value);

    const today = new Date(start_date.value);

    if (isNaN(today.getTime())) {
        errors.push('La fecha de inicio no es válida');
    }

    return errors;
}

function validateEndDate() {
    if(!fieldsTouched.end_date) return [];

    let errors = [];

    if (end_date.value === '') {
        errors.push('La fecha de fin es obligatoria');
        return errors;
    }

    const today = new Date(end_date.value);

    if (isNaN(today.getTime())) {
        errors.push('La fecha de fin no es válida');
    }

    return errors;
}

function validateDateRange() {
    if(!fieldsTouched.start_date || !fieldsTouched.end_date) return [];

    if (validateStartDate().length > 0 || validateEndDate().length > 0) return [];

    let errors = [];
    const start = new Date(start_date.value);
    const end = new Date(end_date.value);

    if (start >= end) {
        errors.push('La fecha de inicio debe ser anterior a la fecha de fin');
    }

    return errors;
}

function validateGuestCount() {
    if(!fieldsTouched.guest_count) return [];
    let errors = [];
    const value = guest_count.value.trim();

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

function validatePaymentMethodId() {
    if(!fieldsTouched.payment_method_id) return [];

    let errors = [];

    if (payment_method_id.value === '') {
        errors.push('El método de pago es obligatorio');
    }

    return errors;
}

async function calculateTotalPrice() {
    if (validateRoomId().length > 0 || validateDateRange().length > 0) {
        return;
    }
    start = new Date(start_date.value);
    end = new Date(end_date.value);
    const response = await fetch(`index.php?action=calculateTotalPrice&roomId=${room_id.value}&startDate=${start.toISOString()}&endDate=${end.toISOString()}`);
    const data = await response.json();
    total_price.textContent = `$${data.totalPrice.toLocaleString()}`;

    //pendiente: ver como manjar el conteo de huéspedes para el cálculo del precio total
}

//------------------------------------------------------------------------------
//listener para cargar habitaciones disponibles según categoría seleccionada
category_id.addEventListener('change', async() => {
    const categoryValue = category_id.value;
    room_id.innerHTML = '';
    const response = await fetch(`index.php?action=getAvailableRooms&categoryId=${categoryValue}`);
    if (!response.status === 401) {
        alert("Sesión expirada");
        window.location.href = "index.php";
        return;
    }

    if (!response.ok) {
        const error = await response.json();
        console.error(error.message);
        return;
    }

    const rooms = await response.json();
    
    if (rooms.length === 0) {
        room_id.innerHTML = '<option value="">No hay habitaciones disponibles</option>';
        room_id.disabled = true;
        return;
    }

    if (room_id.value === '') {
        room_id.innerHTML = '<option value="">Seleccione una habitación</option>';
    }

    room_id.innerHTML = '<option value="">Seleccione una habitación</option>';
    room_id.disabled = false;
    rooms.forEach(room => {
        const option = document.createElement('option');
        
        option.value = room.id;
        option.textContent = room.number;
        room_id.appendChild(option);
    });
});

//listener para cargar precio y cantidad de huéspedes máximos según habitación seleccionada
room_id.addEventListener('change', async () => {
    const roomId = room_id.value;
    if (roomId === '') {
        total_price.textContent = '$0';
        return;
    }
    const response = await fetch(`index.php?action=getGuestCountAndPrice&roomId=${roomId}`);
    if (!response.status === 401) {
        alert("Sesión expirada");
        window.location.href = "index.php";
        return;
    }

    if (!response.ok) {
        const error = await response.json();
        console.error(error.message);
        return;
    }

    const data = await response.json();

    if (data.length === 0) {
        currentGuestCount = 0;
        currentPrice = 0;
        return;
    }
    guest_count.max,currentGuestCount = data.guestCount;
    currentPrice = data.price;
});

function validateForm() {
    let allValid = true;
    fieldsToValidate.forEach(field => {
        if (field.element) {
            const errors = field.validate(field.element);
            if (errors.length > 0) {
            allValid = false;
            }
        }
        if (field.elements) {
            field.elements.forEach(el => {
                const errors = field.validate();
                if (errors.length > 0) {
                allValid = false;
            }
            });
        }
    });
    save_button.disabled = !allValid;
}
//------------------------------------------------------------------------------
// Loop para agregar listeners de validación a cada campo
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

            const errors = field.validate();

            if (errors.length > 0) {
                ErrorHandler.showErrorMessage(el, errors);
            }

            else {
                ErrorHandler.removeErrorMessage(el);
            }
            

            validateForm();

        });

    });

});

//Revisar el hp booking action y putear a chatGPT
