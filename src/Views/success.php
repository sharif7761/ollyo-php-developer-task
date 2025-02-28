<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="max-w-[1200px] mx-auto my-20">
    <p class="text-gray-700 mb-4">Thank you for your payment. Your order has been successfully processed.</p>
    <p class="text-gray-900 font-medium">Order ID: <span class="text-blue-600"><?php echo $data['order_id']; ?></span></p>
    <div class="mt-6">
        <a href="/" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md shadow hover:bg-blue-500">Return to Home</a>
    </div>
</div>
</body>
</html>