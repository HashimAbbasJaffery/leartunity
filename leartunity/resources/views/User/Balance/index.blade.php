<x-layout>
    <div class="container mx-auto flex">
        <div class="justify-between flex rounded banner mt-4 mb-4 p-3 text-white w-2/3 mr-3" style="overflow: hidden;background: linear-gradient(to right, #159957, #155799); height: 150px;">
            <div>
                <p style="opacity: 0.7;">Balance</p>
                <div class="balance mt-1" style="font-size: 25px;">
                    <span class="unit px-2 py-1 rounded" style="background: white; color: black;">{{ $unit }}</span>
                    <span class="ml-1">{{ number_format($balance, 2, ".", ",") }}</span>

                </div>
                
                <div class="profit-loss mt-2" style="font-size: 13px;">
                    <span>+{{ $profit_percentage }}%</span> than last month 
                </div>
                @if(auth()->id() === $user->id)
                    <div class="balance-actions mt-3">
                        <button style="font-size: 13px;">Add Funds</button>
                        <button style="font-size: 13px;" class="ml-1 bg-white text-black px-2 py-1 rounded">Withdraw</button>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex items-center rounded banner mt-4 mb-4 p-3 text-white w-1/3" style="overflow: hidden;background: var(--primary); height: 150px;">
            <div class="profile">
                <img class="ml-3" class="rounded-full" src="/profile/{{ $user->profile->profile_pic }}" alt="">
            </div>
            <div class="profile-detail ml-5" style="font-size: 15px;">
                <span style="display:inline-block; width: 60px;">Name:</span> {{ $user->name }} <br>
                <span style="display:inline-block; width: 60px;">Streak:</span> {{ $user->streak }} Day(s)<br>
                <span style="display:inline-block; width: 60px;">Role:</span> {{ $user->role }} <br>
                <span style="display:inline-block; width: 60px;">Since:</span> {{ $user->created_at->diffForHumans() }} <br>
            </div>
        </div>
    </div>
    <div class="container mx-auto" style="font-size: 13px;">
    <h1 class="text-xl font-bold">Transactions</h1>
    <table id="myTable" class="display">
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Amount</th>
            <th>Transaction date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->transactions as $transaction)
        <tr>
            <td>{{ $transaction->transaction_id }}</td>
            <td>{{ ($transaction->transaction_type == "1")? "+" : "-" }}{{ abs(number_format($transaction->amount * $exchange_rate, 2, ".", ",")) }} {{ $unit }}</td>
            <td>{{ $transaction->created_at->format("d-M-Y") }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</x-layout>
<script>
    let table = new DataTable('#myTable');
</script>