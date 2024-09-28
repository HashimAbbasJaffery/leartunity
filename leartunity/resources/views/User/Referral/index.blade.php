<x-layout>
    <div class="container mx-auto">
        <div class="referral-link" style="margin: 100px 100px;">
            <h1 class="text-center text-xl">@lang('Refer User')</h1>
            <div class="link-box" style="display: flex; justify-content: center; width: 100%;">
                <input type="text" id="link" value="{{ route("register") }}?id={{ auth()->id() }}" readonly>
                <button style="background: black; color: white;" class="px-2" id="copyButton">@lang('Copy')</button>
            </div>
        </div>
        <div class="referral-list">
            <h1 class="text-xl">@lang("Referrals")</h1>
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>@lang("Name")</th>
                        <th>@lang("Email")</th>
                        <th>@lang("Balance")</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($referrals as $referral)
                        <tr>
                            <td>{{ $referral->name }}</td>
                            <td>{{ $referral->email }}</td>
                            <td>{{ $referral->balance }} $</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="benefits mt-5">
            <h1 class="text-xl">@lang("Referral Perk")</h1>
            <p>@lang("By referring other person, and if they register by your referral link and make a first purchase, then you will get 1$. It applies on every referred person you have but only works in their first purchase")</p>
        </div>
    </div>
    <script>
        const textToCopy = document.getElementById("link").value;
        const copyButton = document.getElementById("copyButton");

        copyButton.addEventListener("click", function() {
            if(copyButton.disabled) return;
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    copyButton.textContent = '@lang("Copied")'
                    copyButton.disabled = true;
                    setInterval(() => {
                        copyButton.textContent = '@lang("Copy")'
                        copyButton.disabled = false;
                    }, 5000);
                })
                .catch(err => {
                    alert(err)
                })
        })

    </script>

    <script>
        let table = new DataTable('#myTable');
    </script>
</x-layout>
