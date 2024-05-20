<x-layout>
    <div class="container mx-auto text-center" style="margin: 120px 120px;">
        <h1>Add Funds</h1>
        <form action="{{ route("add.balance") }}" method="POST" style="display: inline-block;">
            @csrf
            <div class="amount flex justify-center">
                <input type="number" name="fund-amount" id="amount" style="outline: none" placeholder="Amount">
                <div class="unit flex items-center justify-center" style="background: var(--primary); color: white; width: 25px;">{{ $unit }}</div>
            </div>
            <p data-tooltip-target="tooltip-default" class="amount-message" style="cursor: pointer; display: none;"><span class="total-amount"></span>{{ $unit }} will be deposited into your account <sup>?</sup></p>
            <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                3% platform fee will be deducted
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <input type="submit" value="Add Fund" style="border-radius: 0px;" class="mt-3">
        </form>
    </div>
</x-layout>
<script>
    const amount = document.getElementById("fund-amount");
    amount.addEventListener("keyup", function() {
        const totalAmount = document.querySelector(".total-amount");
        const message = document.querySelector(".amount-message");
        
        if(amount.value) {
            
            message.style.display = "block";
            const value = amount.value;
            const fee = 3;
            let finalValue;

            finalValue = value - ((value * fee) / 100);
            totalAmount.textContent = finalValue;
        } else {
            message.style.display = "none";
        }
    })
</script>