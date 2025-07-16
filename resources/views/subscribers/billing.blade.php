
<style>
  .bills .billing-container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .bills h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .bills label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    .bills input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .bills .form-group {
      margin-bottom: 15px;
    }
    .bills .checkbox-group {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }
    .bills .checkbox-group input {
      width: auto;
      margin-right: 10px;
    }
    .bills button {
      width: 100%;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }
    .bills button:hover {
      background-color: #0056b3;
    }

    @media (max-width: 600px) {
      .bills .billing-container {
        padding: 15px;
      }
    }

</style>

<x-layout>

   <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Requests</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="/">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/">Home</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/billing">Billing</a>
                </li>
              </ul>
            </div>
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
              <h2 class="text-2xl font-semibold text-gray-800 mb-6">Your Transactions</h2>
          
              @forelse($transactions as $transaction)
              <div class="bg-white rounded-2xl shadow p-6 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                  <div>
                      <h3 class="text-lg font-bold text-gray-900 mb-1">Transaction #{{ $transaction->transaction_id }}</h3>
                      <p class="text-sm text-gray-600">
                          <span class="font-medium">Date:</span> {{ $transaction->created_at->format('d M Y, h:i A') }}
                      </p>
                      <p class="text-sm text-gray-600">
                          <span class="font-medium">Payment Method:</span> {{ ucfirst($transaction->payment_method) }}
                      </p>
                  </div>
          
                  <div class="text-center sm:text-right">
                      <p class="text-sm text-gray-600">
                          <span class="font-medium">Plan:</span> {{ $transaction->plan->name ?? 'N/A' }}
                      </p>
                      <p class="text-sm text-gray-600">
                          <span class="font-medium">Credits:</span> {{ $transaction->credits_purchased }}
                      </p>
                      <p class="text-xl font-semibold text-green-600">${{ number_format($transaction->amount_paid, 2) }}</p>
                  </div>
              </div>
              @empty
              <div class="text-center text-gray-500 mt-10">
                  <p>No transactions found.</p>
              </div>
              @endforelse
          </div>
          </div>
   </div>


   <script>
    function submitBilling() {
      const plan = document.getElementById("plan").value;
      const name = document.getElementById("name").value;
      const address = document.getElementById("address").value;
      const payment = document.getElementById("payment").value;
      const recurring = document.getElementById("recurring").checked;

      if (!plan || !name || !address || !payment) {
        alert("Please fill out all fields.");
        return;
      }

      alert(`Plan: ${plan}\nName: ${name}\nAddress: ${address}\nPayment: ${payment}\nRecurring: ${recurring ? 'Yes' : 'No'}`);
    }
  </script>
</x-layout>