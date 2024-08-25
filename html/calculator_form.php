<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <title>BMI Calculator</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f3f4f6; /* Tailwind's bg-gray-100 */
        }
    </style>
</head>
<body>

    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center text-indigo-600 mb-6">BMI Calculator</h2>
        <form action="php/calculate_bmi.php" method="post" id="bmiForm" class="space-y-6">
            <div class="rounded-md shadow-sm">
                <div>
                    <label for="name" class="sr-only">Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Name">
                </div>
                <div class="mt-4">
                    <label for="age" class="sr-only">Age</label>
                    <input id="age" name="age" type="number" autocomplete="age" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Age">
                </div>
                <div class="mt-4">
                    <label for="gender" class="sr-only">Gender</label>
                    <select id="gender" name="gender" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 text-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="height" class="sr-only">Height (meters)</label>
                    <input id="height" name="height" type="number" step="0.01" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Height (meters)">
                </div>
                <div class="mt-4">
                    <label for="weight" class="sr-only">Weight (kilograms)</label>
                    <input id="weight" name="weight" type="number" step="0.1" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Weight (kilograms)">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> Calculate BMI </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('bmiForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('php/calculate_bmi.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.success ? 'success' : 'error',
                title: data.success ? 'BMI Calculated' : 'Error',
                html: data.success 
                    ? `<p>${data.message}</p><p><strong>Health Status:</strong> ${data.health_status}</p><p><strong>Tip:</strong> ${data.tip}</p>` 
                    : data.message,
                timer: 10000,
                showConfirmButton: true
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                timer: 3000,
                showConfirmButton: false
            });
        });
    });
    </script>
</body>
</html>
