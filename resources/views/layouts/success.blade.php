<html>
  <head>
    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="@isset($HallOption)
        {{ $HallOption[0]->value }}
    @endisset" />
        <title>Payment Success - @isset($HallOption)
            {{ $HallOption[0]->value }}
        @endisset </title>
        <link rel="icon" type="image/x-icon" href="{{ asset($HallOption[6]->value) }}" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i><br>
      </div>
        <h1>Success</h1> 
        @if ($data==2)
        <p>Transaction is already Successful! We received your payment request;<br/> We'll be in touch shortly! Once Accepted you will be notified via a email!<br/> Thanks.</p>
        @else
        <p>We received your payment request;<br/> We'll be in touch shortly! Once Accepted you will be notified via a email!<br/> Thanks.</p>
        @endif
      </div>
    </body>
</html>