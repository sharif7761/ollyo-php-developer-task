<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="max-w-[1200px] mx-auto my-20">
    <p class="text-gray-900 font-medium">
        Error Message:
        <span class="text-red-600">
                    <?php echo isset($errorMessage) ? htmlspecialchars($errorMessage) : 'An unknown error occurred.'; ?>
        </span>
    </p>
    <div class="mt-6">
        <a href="/checkout" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md shadow hover:bg-blue-500">Go Back to Checkout</a>
    </div>
</div>
</body>
</html>