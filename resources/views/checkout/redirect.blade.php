@extends("admin.template")

@section("heading")
  Redirecting to Stripe
@endsection

@section("javascript")
  @parent
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    $(document).ready(function () {
      let stripe = Stripe("{{ config("services.stripe.public_key") }}");
      result = stripe.redirectToCheckout({ sessionId: "{{$sessionId}}"});

      if (result.error) {
        alert(result.error.message);
      }
    });
  </script>
@endsection

@section("content")
  <div class="centered" style="text-align: center">
    <h3>Sending to Stripe</h3>
    <span class="fas fa-spinner fa-pulse fa-2x"></span>
  </div>
@endsection
