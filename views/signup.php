<?php
require_once ('../../config.php');
session_start();
$token = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : "";
if (!$token) {
    $token = md5(uniqid());
    $_SESSION['csrf_token'] = $token;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self'">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to chatex - Create an account in few steps</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="shortcut icon" href="../src/images/logo.ico" type="image/x-icon" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="../src/js/common.js"></script>
    <script src="../src/js/signup.js" type="module" defer></script>
    <link rel="stylesheet" href="../src/css/signup.css">
    <link rel="stylesheet" href="../src/css/toast.css">
    <!-- <link rel="stylesheet" href="../src/css/root.css"> -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        if (top !== self) {
            top.location = self.location;
        }

        if (window !== top) {
            top.location = window.location;
        }
    </script>
</head>

<body>
    <main>
        <div class="logo">
            <img src="../src/images/logo.svg" alt="" />
            <h2>Chatex</h2>
        </div>
        <section class="left-wrapper">
            <!-- <img src="../src/images/sgn-banner-mobile.svg" class="left-bg" alt="" hidden> -->
            <div class="heading-wrapper">
                <h2 class="header">Create account</h2>
                <p class='create-account-descr'>Create your account within a few steps <br> and start your 7-day free
                    trial now.</p>
                <p class="email-send-text">
                <p>
            </div>
            <form action="" class="sign-up-form" autocomplete="off">
                <input type="text" hidden />
                <div class="plan-wrapper">
                    <div class="pricing-wrapper">
                        <div class="price-wrapper">
                            <img src="../src/images/diamond.png" alt="pricing logo" class="pricing_img" />
                            <h3>Basic Plan</h3>
                            <div class="pricing-div">
                                <h1 class="pricing-h1">$10</h1>
                                <span>per month</span>
                            </div>
                        </div>
                        <div class="offering-wrapper">
                            <li>Dedicated dashboard</li>
                            <li>Chat history</li>
                            <li>Response templates</li>
                            <li>Total 100 messages</li>
                            <li>Voice & SMS notifications</li>
                            <li>AI chatbot</li>
                        </div>
                        <a class="signup-btn" plan="basic">Choose this plan</a>
                    </div>
                    <div class="pricing-wrapper">
                        <div class="price-wrapper">
                            <img src="../src/images/diamond1.png" alt="pricing logo" class="pricing_img" />
                            <h3>Premium Plan</h3>
                            <div class="pricing-div">
                                <h1 class="pricing-h1">$25</h1>
                                <span>per month</span>
                            </div>
                        </div>
                        <div class="offering-wrapper">
                            <li>Dedicated dashboard</li>
                            <li>Chat history</li>
                            <li>Response templates</li>
                            <li>Total 500 messages</li>
                            <li>Voice & SMS notifications</li>
                            <li>AI with human escalation</li>
                        </div>
                        <a class="signup-btn" plan="premium">Choose this plan</a>
                    </div>
                </div>
                <div class="main-wrapper">
                    <div class="input-wrapper">
                        <label for="email">Email</label>
                        <input type="mail" name="email" id="email" />
                        <p class="email-err">Please enter a valid email address</p>
                        <p class="servr-err">This email address is already in use</p>
                    </div>
                    <div class="input-wrapper">
                        <label for="email">Password</label>
                        <div class="password-input-wrapper">
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                maxlength="30" />
                            <svg class=" show-password-btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24">
                                <title>Show password</title>
                                <path fill="currentColor"
                                    d="M12 9.005a4 4 0 1 1 0 8a4 4 0 0 1 0-8Zm0 1.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5ZM12 5.5c4.613 0 8.596 3.15 9.701 7.564a.75.75 0 1 1-1.455.365a8.504 8.504 0 0 0-16.493.004a.75.75 0 0 1-1.456-.363A10.003 10.003 0 0 1 12 5.5Z" />
                            </svg>
                            <svg class="hide-password-btn" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24">
                                <title>Hide password</title>
                                <path fill="currentColor"
                                    d="M2.22 2.22a.75.75 0 0 0-.073.976l.073.084l4.034 4.035a9.986 9.986 0 0 0-3.955 5.75a.75.75 0 0 0 1.455.364a8.49 8.49 0 0 1 3.58-5.034l1.81 1.81A4 4 0 0 0 14.8 15.86l5.919 5.92a.75.75 0 0 0 1.133-.977l-.073-.084l-6.113-6.114l.001-.002l-1.2-1.198l-2.87-2.87h.002l-2.88-2.877l.001-.002l-1.133-1.13L3.28 2.22a.75.75 0 0 0-1.06 0Zm7.984 9.045l3.535 3.536a2.5 2.5 0 0 1-3.535-3.535ZM12 5.5c-1 0-1.97.148-2.889.425l1.237 1.236a8.503 8.503 0 0 1 9.899 6.272a.75.75 0 0 0 1.455-.363A10.003 10.003 0 0 0 12 5.5Zm.195 3.51l3.801 3.8a4.003 4.003 0 0 0-3.801-3.8Z" />
                            </svg>
                        </div>
                        <p class="password-err">The password should be at least 8 characters long</p>
                        <p class="wrong-pass-err">The password you entered is incorrect.</p>

                    </div>
                </div>
                <div class="otp-wrapper">
                    <div class="input-wrapper">
                        <label for="otp">OTP</label>
                        <input type="text" name="otp" id="otp"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                            maxlength="8" />
                        <p class="otp-err">The OTP (One-Time Password) you entered is incorrect</p>
                    </div>
                </div>
                <div class="info-wrapper">
                    <div class="input-wrapper">
                        <label for="customer-name">Name</label>
                        <input type="text" name="customer-name" id="customer-name" maxlength="32" />
                    </div>
                    <div class="input-wrapper">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1'); if(this.value.length > 10) this.value = this.value.slice(0, 10);" />
                        <p class="phone-err">Please provide a valid phone number</p>
                    </div>
                    <div class="input-wrapper">
                        <label for="business">website</label>
                        <input type="text" name="business" id="business"
                            oninput="this.value = this.value.replace(/[^a-zA-Z0-9'.\-/:?=%&_\s!@#$()+]/g, '');">
                        <p class="business-err">Please provide a valid website</p>
                    </div>
                    <!-- <p class="phone-descr secondary-text">You will receive customer notifications via SMS or a voice call to the phone number provided above. To proceed, click 'Next'</p> -->
                </div>
                <div class="payment-wrapper">
                    <div class="input-wrapper">
                        <label for="card-type">Card type</label>
                        <select name="card-type" id="card-type">
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                            <option value="prepaid_card">Prepaid</option>
                        </select>
                    </div>
                    <div class="input-wrapper">
                        <label for="card_element">Card details</label>
                        <div>
                            <div id="card_element" class="stripe-card-field">
                            </div>
                            <div class="reference-wrapper">
                                <p class="reference-text">Powered by </p>
                                <a class="stripe-reference" href="http://stripe.com" target="_blank"
                                    rel="noopener noreferrer"><strong>Stripe</strong></a>
                            </div>
                        </div>
                        <p class="card-err"></p>
                    </div>
                </div>
                <p class="payment-description">Your card will not be charged now. You have the option to cancel within a
                    7-day period to avoid any charges to your card. After the initial week, a total of $10 will be
                    charged per month.</p>
                </div>

                <div class="btn-wrapper">
                    <span class="back-btn">Back</span>
                    <span id="change-plan" type="submit">Change plan</span>
                    <button id="sign-up" data-action="personal" type="submit">Next</button>
                    <input type="hidden" id="csrf_token" value="<?php echo $token; ?>">
                </div>
                <div class="resend-wrapper">
                    <button disabled class="timer-btn" type="submit">Resend OTP in <span
                            class="timer">60</span></button>
                </div>
                <div class="con-modal" id="con-myModal">
                    <div class="con-modal-content">
                        <h4>Confirm Account Creation</h4>
                        <br>
                        <div class="con-modal-text-wrapper">
                            <div class="con-modal-input-wrapper">
                                <p class='signup-already-text'>Your card number is already associated with an existing
                                    account, and as a result, you won't be eligible for a trial. A charge of $10 will be
                                    applied immediately.</p>
                                <p>Are you sure you want to continue?</p>
                            </div>
                            <div>
                                <button type="button" id="con-yes">Yes</button>
                                <a class="con-no" id='con-no'>No</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lds-ellipsis loader-js">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </form>
            <div class="signup-wrapper">
                <span>Already have an account?</span><a href="./signin" rel="noopener noreferrer" class="singup-anchor"
                    id="signin-button">Sign in</a>
            </div>
            <div class="terms-and-privacy">
                <a href="https://www.nethram.com/terms-and-conditions/" rel="noopener noreferrer"
                    class="singup-anchor">Terms of services</a><span>&nbsp;|&nbsp;</span><a
                    href="https://www.nethram.com/privacy-policy/" rel="noopener noreferrer"
                    class="singup-anchor">Privacy policy</a>
            </div>
        </section>
        <section class="right-wrapper"></section>
    </main>
</body>
<script type="text/javascript">
    var stripe_public = "<?= $stripe_p_key; ?>";
</script>

</html>