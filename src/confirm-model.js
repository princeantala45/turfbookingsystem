document.getElementById("bookingForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent actual submit

  const form = this;

  const data = {
    Fullname: form.fullname.value,
    Email: form.email.value,
    Mobile: form.mobile.value,
    State: form.state.value,
    City: form.city.value,
    Pincode: form.pincode.value,
    Address: form.address.value,
    Date: form.date.value,
    Turf: form.turfs.value,
    Payment_Method: form.payment_method.value
  };

  if (data.Payment_Method === "card") {
    data.Card_Number = form.cardnumber.value;
    data.Cardholder_Name = form.cardholdername.value;
    data.Expiry = form.expiry.value;
    data.CVV = form.cvv.value;
  } else if (data.Payment_Method === "upi") {
    data.UPI_ID = form.upi.value;
  }

  // Pricing logic
  const turfPrices = {
    "archery": 1500, "badminton": 8000, "baseball": 5000,
    "basketball": 4500, "cricket": 10000, "football": 5000,
    "golf": 1500, "hockey": 3000, "tennis": 2500,
    "volleyball": 2000, "javelin": 1000, "kho-kho": 1100
  };

  const lowerTurf = data.Turf.toLowerCase();
  const price = turfPrices[lowerTurf] || 0;
  const cgst = (price * 0.09).toFixed(2);
  const sgst = (price * 0.09).toFixed(2);
  const total = (price + parseFloat(cgst) + parseFloat(sgst)).toFixed(2);

  // Build confirmation message
  let message = "🔍 Please confirm your booking details:\n\n";
  for (let key in data) {
    message += `• ${key.replace(/_/g, " ")}: ${data[key]}\n`;
  }
  message += `\n💰 Base Price: ₹${price}\n📊 CGST (9%): ₹${cgst}\n📊 SGST (9%): ₹${sgst}\n🧾 Total: ₹${total}`;

  // Display modal
  document.getElementById("confirmMessage").textContent = message;
  document.getElementById("confirmModal").classList.remove("hidden");

  // Handle continue
  document.getElementById("continueBtn").onclick = () => {
    document.getElementById("confirmModal").classList.add("hidden");
    form.submit(); // Allow actual submission
  };

  // Handle cancel
  document.getElementById("cancelBtn").onclick = () => {
    document.getElementById("confirmModal").classList.add("hidden");
  };
});

// Payment field logic
window.addEventListener("DOMContentLoaded", () => {
  const paymentSelect = document.getElementById("payment_method");
  const cardFields = document.getElementById("card_fields");
  const upiFields = document.getElementById("upi_fields");

  const cardInputs = cardFields.querySelectorAll("input");
  const upiInputs = upiFields.querySelectorAll("input");

  function toggleFields() {
    const method = paymentSelect.value;
    cardFields.classList.add("hidden");
    upiFields.classList.add("hidden");
    cardInputs.forEach(input => input.required = false);
    upiInputs.forEach(input => input.required = false);

    if (method === "card") {
      cardFields.classList.remove("hidden");
      cardInputs.forEach(input => input.required = true);
    } else if (method === "upi") {
      upiFields.classList.remove("hidden");
      upiInputs.forEach(input => input.required = true);
    }
  }

  paymentSelect.addEventListener("change", toggleFields);
  toggleFields(); // Apply on load
});