<form action="{{ route('uniquepay.payment.create') }}" method="POST">
    @csrf
    <input type="text" name="cus_name" placeholder="Your Name" required>
    <input type="email" name="cus_email" placeholder="Your Email" required>
    <input type="text" name="phone" placeholder="Your Phone" required>
    <input type="number" name="amount" placeholder="Amount" required>
    <button type="submit">Pay Now</button>
</form>