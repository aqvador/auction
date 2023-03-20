<form action="/auction/v1/create" method="POST">
    <div class="form-example">
        <label for="name">Enter lot name: </label>
        <input type="text" name="auction_name" id="name" required>
    </div>
    <div class="form-example">
        <label for="name">Enter step time seconds: </label>
        <input type="number" name="step_time" id="name" required>
    </div>
    <div class="form-example">
        <label for="name">Enter step price: </label>
        <input type="text" name="auction_price" id="name" required>
    </div>
    <div class="form-example">
        <input type="submit">
    </div>
</form>
