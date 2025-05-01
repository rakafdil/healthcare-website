// In your peta.blade.php JavaScript
function getNearbyHospitals(lat, lng) {
    fetch(`/api/nearby-hospitals?lat=${lat}&lng=${lng}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        // Process the data returned from your controller
        processHospitalData(data);
    })
    .catch(error => {
        console.error('Error fetching hospital data:', error);
    });
}