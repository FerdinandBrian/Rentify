<script>
    document.querySelectorAll('form').forEach((form) => {
        const carSelect = form.querySelector('select[name="car_series_number"]');
        const paymentSelect = form.querySelector('select[name="payment_id"]');

        if (!carSelect || !paymentSelect) {
            return;
        }

        const syncPaymentOptions = () => {
            const selectedCar = carSelect.value;

            [...paymentSelect.options].forEach((option) => {
                const optionCar = option.dataset.car;
                option.hidden = Boolean(optionCar) && selectedCar !== optionCar;
            });

            const selectedOption = paymentSelect.selectedOptions[0];
            if (selectedOption?.hidden) {
                paymentSelect.value = '';
            }
        };

        carSelect.addEventListener('change', syncPaymentOptions);
        syncPaymentOptions();
    });
</script>
