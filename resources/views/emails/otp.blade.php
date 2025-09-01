<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaction PIN Reset - Fee24MFB</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="email-wrapper">
      <!-- Header -->
      <div class="header">
        <div class="icon-container">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#2ecc71" class="success-icon" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8" fill="#e8f5e9"/>
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.03 7.97a.75.75 0 0 0-1.06 1.06l2 2z"/>
          </svg>
        </div>
        <h1 class="title">Transaction PIN Reset</h1>
        <p class="subtitle">
          Dear <span class="highlight">{{ Auth::user()->first_name ?? 'Valued Customer' }}</span>,
        </p>
        <p>Your request to reset your transaction PIN has been received. Please use the One-Time Password (OTP) below to complete the process.</p>
      </div>

      <!-- OTP Display -->
      <div class="otp-container">
        <p>Your One-Time Password (OTP) for {{ $appName }} is:</p>
        @component('mail::panel')
        <strong class="otp-code">{{ $otp }}</strong>
        @endcomponent
        <p class="otp-warning">⚠️ This code is valid for only <strong>2 minutes</strong>. For your security, <strong>do not share this code with anyone</strong>.</p>
      </div>

      <!-- Info Box -->
      <div class="info-box">
        <p class="info-text">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#0066cc" style="vertical-align:middle;margin-right:3px;" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm0-1A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm.93-6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 .875-.252 1.02-.797l.088-.416c.073-.34.211-.466.465-.466.245 0 .451.176.378.533l-.088.416c-.235 1.07-.972 1.434-1.764 1.434-.972 0-1.393-.563-1.19-1.445l.738-3.468c.194-.897-.105-1.32-.808-1.32-.545 0-.875.252-1.02.797l-.089.416c-.072.34-.211.466-.465.466-.244 0-.451-.176-.377-.533l.088-.416c.234-1.07.972-1.434 1.764-1.434.972 0 1.393.563 1.19 1.445zm-.93-1.517a.875.875 0 1 1 .001-1.75.875.875 0 0 1-.001 1.75z"/>
          </svg>
          <strong>Need Help?</strong> If you did not request this PIN reset or have any complaints, please <strong>Contact Us</strong> immediately.
        </p>
        <p class="info-text">Thank you for trusting Fee24 Microfinance Bank.</p>
      </div>

      <!-- Footer -->
      <div class="footer">
        <h4 class="subtitle" style="margin-bottom: 20px;">Follow Us</h4>
        <div class="social-links">
          <a href="#" class="social-link" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="social-icon" viewBox="0 0 16 16"><path d="M16 8a8 8 0 1 0-9.25 7.906v-5.593H4.672V8h2.078V6.275c0-2.053 1.225-3.197 3.1-3.197.899 0 1.841.16 1.841.16v2.021h-1.037c-1.022 0-1.34.634-1.34 1.287V8h2.281l-.365 2.313h-1.916V15.9A8.001 8.001 0 0 0 16 8z"/></svg>
          </a>

          <a href="#" target="_blank" class="social-link" aria-label="WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="social-icon" viewBox="0 0 16 16">
              <path d="M13.601 2.326A7.994 7.994 0 0 0 8.002 0C3.582 0 0 3.582 0 8.002c0 1.414.367 2.789 1.063 4.004L0 16l4.114-1.044A7.953 7.953 0 0 0 8.002 16c4.42 0 8.002-3.582 8.002-7.998a7.96 7.96 0 0 0-2.403-5.676ZM8.002 14.5a6.475 6.475 0 0 1-3.307-.896l-.236-.14-2.437.62.65-2.374-.153-.244a6.478 6.478 0 0 1-1.001-3.434c0-3.583 2.918-6.5 6.484-6.5 1.736 0 3.366.676 4.593 1.904a6.452 6.452 0 0 1 1.891 4.592c0 3.583-2.918 6.472-6.484 6.472Zm3.552-4.867c-.194-.097-1.152-.57-1.332-.634-.179-.065-.31-.097-.441.097-.132.194-.506.634-.62.764-.114.129-.228.146-.423.049-.194-.097-.82-.302-1.563-.963-.577-.514-.966-1.146-1.08-1.34-.114-.194-.012-.298.085-.395.087-.086.194-.228.291-.342.097-.114.129-.194.194-.324.065-.129.033-.243-.016-.34-.049-.097-.441-1.065-.604-1.46-.16-.388-.323-.335-.441-.341-.114-.006-.243-.007-.373-.007-.129 0-.34.049-.518.243-.179.194-.679.663-.679 1.618 0 .955.696 1.877.793 2.006.097.129 1.371 2.094 3.327 2.938.465.201.828.321 1.11.412.465.148.889.127 1.225.077.373-.056 1.152-.47 1.314-.923.162-.453.162-.84.114-.923-.049-.084-.178-.13-.372-.227Z"/>
            </svg>
          </a>

          <a href="#" class="social-link" aria-label="Twitter">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="social-icon" viewBox="0 0 16 16"><path d="M16 3.039a6.461 6.461 0 0 1-1.885.516A3.293 3.293 0 0 0 15.558 2.1a6.574 6.574 0 0 1-2.084.797A3.282 3.282 0 0 0 7.875 5.03a9.325 9.325 0 0 1-6.766-3.429 3.3 3.3 0 0 0 1.014 4.382A3.323 3.323 0 0 1 .64 5.575v.041a3.288 3.288 0 0 0 2.633 3.218 3.203 3.203 0 0 1-.865.115c-.211 0-.417-.021-.616-.061a3.293 3.293 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.032 15c6.038 0 9.341-5 9.341-9.334 0-.143-.004-.283-.011-.422A6.847 6.847 0 0 0 16 3.039z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="LinkedIn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="social-icon" viewBox="0 0 16 16"><path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.521-1.248-1.342-1.248-.82 0-1.357.539-1.357 1.248 0 .694.52 1.248 1.327 1.248h.014zm4.908 8.212h2.4v-4.045c0-.216.016-.432.08-.586.175-.432.572-.88 1.238-.88.873 0 1.222.665 1.222 1.641v3.87h2.4v-4.148c0-2.22-1.184-3.252-2.762-3.252-1.273 0-1.845.705-2.165 1.203h.027v-1.034h-2.401c.033.677 0 7.225 0 7.225z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="social-icon" viewBox="0 0 16 16"><path d="M8 3c1.654 0 1.863.006 2.522.037.659.03.995.14 1.23.23a2.478 2.478 0 0 1 .904.522c.268.267.44.566.522.904.09.235.2.571.23 1.23C12.994 6.137 13 6.346 13 8s-.006 1.863-.037 2.522c-.03.659-.14.995-.23 1.23a2.478 2.478 0 0 1-.522.904c-.267.268-.566.44-.904.522-.235.09-.571.2-1.23.23C9.863 12.994 9.654 13 8 13s-1.863-.006-2.522-.037c-.659-.03-.995-.14-1.23-.23a2.478 2.478 0 0 1-.904-.522 2.478 2.478 0 0 1-.522-.904c-.09-.235-.2-.571-.23-1.23C3.006 9.863 3 9.654 3 8s.006-1.863.037-2.522c.03-.659.14-.995.23-1.23a2.478 2.478 0 0 1 .522-.904A2.478 2.478 0 0 1 5.686 3.26c.235-.09.571-.2 1.23-.23C6.137 3.006 6.346 3 8 3m0-1C6.326 2 6.096 2.007 5.435 2.038c-.667.031-1.125.142-1.519.304a3.479 3.479 0 0 0-1.273.815 3.479 3.479 0 0 0-.815 1.273c-.162.394-.273.852-.304 1.519C2.007 6.096 2 6.326 2 8s.007 1.904.038 2.565c.031.667.142 1.125.304 1.519.175.423.447.802.815 1.273s.85.64 1.273.815c.394.162.852.273 1.519.304.661.031.891.038 2.565.038s1.904-.007 2.565-.038c.667-.031 1.125-.142 1.519-.304a3.479 3.479 0 0 0 1.273-.815 3.479 3.479 0 0 0 .815-1.273c.162-.394.273-.852.304-1.519.031-.661.038-.891.038-2.565s-.007-1.904-.038-2.565c-.031-.667-.142-1.125-.304-1.519a3.479 3.479 0 0 0-.815-1.273z"/><path d="M8 5.5A2.5 2.5 0 1 0 8 10a2.5 2.5 0 0 0 0-4.5zm0 1A1.5 1.5 0 1 1 8 9a1.5 1.5 0 0 1 0-3zm4.5-1.14a.601.601 0 1 0 0 1.2.601.601 0 0 0 0-1.2z"/></svg>
          </a>
        </div>
        
        <div class="divider"></div>
        
        <p class="footer-text">
          © {{ date('Y') }} Fee24 Microfinance Bank. All Rights Reserved.
        </p>
        <a href="#" class="footer-link">Unsubscribe</a>
      </div>
    </div>
  </div>
</body>
</html>


  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Nunito Sans', sans-serif;
      background-color: #F9FAFC;
      margin: 0;
      padding: 20px 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    .container {
      max-width: 650px;
      width: 100%;
      margin: 0 auto;
      padding: 0 15px;
    }
    .email-wrapper {
      background: #ffffff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      overflow: hidden;
      padding: 40px 30px;
    }
    .header {
      text-align: center;
      padding-bottom: 25px;
      border-bottom: 1px solid #eaeaea;
      margin-bottom: 30px;
    }
    .logo {
      max-width: 180px;
      margin-bottom: 25px;
    }
    .icon-container {
      width: 80px;
      height: 80px;
      background: #e8f5e9;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
    }
    .success-icon {
      color: #2ecc71;
      font-size: 40px;
    }
    .title {
      color: #2c3e50;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 15px;
    }
    .subtitle {
      color: #7f8c8d;
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 5px;
    }
    .highlight {
      color: #2c3e50;
      font-weight: 600;
    }
    .ticket-details {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0 30px;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .ticket-details th {
      background-color: #f8f9fa;
      padding: 16px;
      text-align: left;
      font-weight: 600;
      color: #2c3e50;
      border-bottom: 1px solid #eaeaea;
      width: 35%;
    }
    .ticket-details td {
      padding: 16px;
      text-align: left;
      color: #555;
      border-bottom: 1px solid #eaeaea;
    }
    .ticket-details tr:last-child th,
    .ticket-details tr:last-child td {
      border-bottom: none;
    }
    .status {
      padding: 6px 12px;
      border-radius: 50px;
      font-size: 12px;
      font-weight: 600;
      display: inline-block;
    }
    .status-open {
      background: #e8f4ff;
      color: #0066cc;
    }
    .info-box {
      background: #f0f7ff;
      border-left: 4px solid #0066cc;
      padding: 20px;
      border-radius: 4px;
      margin: 25px 0;
    }
    .info-text {
      color: #2c3e50;
      font-size: 15px;
      line-height: 1.6;
    }
    .footer {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 30px;
      margin-top: 35px;
      text-align: center;
    }
    .social-links {
      display: flex;
      justify-content: center;
      margin-bottom: 25px;
    }
    .social-link {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #ffffff;
      color: #308e87;
      border: 1px solid #308e87;
      margin: 0 8px;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    .social-link:hover {
      background: #308e87;
      color: #ffffff;
      transform: translateY(-3px);
    }
    .social-icon {
      font-size: 18px;
    }
    .footer-text {
      color: #7f8c8d;
      font-size: 13px;
      margin-bottom: 10px;
    }
    .footer-link {
      color: #308e87;
      font-weight: 600;
      font-size: 13px;
      text-decoration: none;
    }
    .divider {
      height: 1px;
      background: #eaeaea;
      margin: 20px 0;
    }
    
    /* Responsive styles */
    @media only screen and (max-width: 650px) {
      .container {
        width: 100% !important;
        padding: 0 10px;
      }
      .email-wrapper {
        padding: 25px 20px;
      }
      .logo {
        max-width: 140px;
      }
      .title {
        font-size: 20px;
      }
      .ticket-details th,
      .ticket-details td {
        padding: 12px 10px;
        font-size: 14px;
      }
      .ticket-details {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      .footer {
        padding: 20px 15px;
      }
      .social-link {
        width: 36px;
        height: 36px;
        margin: 0 5px;
      }
    }
  </style>