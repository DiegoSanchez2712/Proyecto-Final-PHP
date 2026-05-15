export async function fetchAvailableRooms(categoryId) {
    const response = await fetch(`index.php?action=getAvailableRooms&categoryId=${categoryId}`);
    
    if (response.status === 401) {
        alert("Sesión expirada");
        window.location.href = "index.php";
        return;
    }
    if (!response.ok) {
        const error = await response.json();
        console.error(error.message);
        return;
    }
    return await response.json();
}

export async function fetchGuestCountAndPrice(roomId) {
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
    
    return await response.json();
}