<form method="post" id="paymentForm">

    <div class="form-box">
        <input type="email" id="email" name="email" 
               placeholder=" " value="<?= htmlspecialchars($email ?? '') ?>" />
        <label for="email">Email</label>
        <div class="message"><?= $errors['email'] ?? '' ?></div>
    </div>

    <div class="checkbox">
        <input type="checkbox">
        <label>Email me with news and offers</label>
    </div>

    <h2>Delivery</h2>

    <div class="form-box">
        <select id="country" name="country" style="width:100%;">
            <option value="malaysia" <?= (($country ?? '') === 'malaysia') ? 'selected' : '' ?>>Malaysia</option>
        </select>
        <label for="country">Country/Region</label>
        <div class="message"><?= $errors['country'] ?? '' ?></div>
    </div>

    <div class="form-box">
        <div class="form-row">
            <div class="form-group">
                <input type="text" id="firstName" name="firstName" 
                       value="<?= htmlspecialchars($firstName ?? '') ?>" placeholder=" " />
                <label for="firstName">First Name</label>
                <div class="message"><?= $errors['firstName'] ?? '' ?></div>
            </div>
            <div class="form-group">
                <input type="text" id="lastName" name="lastName" 
                       value="<?= htmlspecialchars($lastName ?? '') ?>" placeholder=" " />
                <label for="lastName">Last Name</label>
                <div class="message"><?= $errors['lastName'] ?? '' ?></div>
            </div>
        </div>
    </div>

    <div class="form-box">
        <input type="text" id="address" name="address" 
               value="<?= htmlspecialchars($address ?? '') ?>" placeholder=" " />
        <label for="address">Address</label>
        <div class="message"><?= $errors['address'] ?? '' ?></div>
    </div>

    <div class="form-box">
        <input type="text" id="apartment" name="apartment" 
               value="<?= htmlspecialchars($apartment ?? '') ?>" placeholder="" />
        <label for="apartment">Apartment, suite, etc. (optional)</label>
        <div class="message"><?= $errors['apartment'] ?? '' ?></div>
    </div>

    <div class="form-box">
        <div class="form-row">
            <div class="form-group">
                <input type="text" id="postcode" name="postcode" 
                       value="<?= htmlspecialchars($postcode ?? '') ?>" placeholder="" />
                <label for="postcode">Postcode</label>
                <div class="message"><?= $errors['postcode'] ?? '' ?></div>
            </div>
            <div class="form-group">
                <input type="text" id="city" name="city" 
                       value="<?= htmlspecialchars($city ?? '') ?>" placeholder="" />
                <label for="city">City</label>
                <div class="message"><?= $errors['city'] ?? '' ?></div>
            </div>
            <div class="form-group">
                <select id="state" name="state">
                    <option value="johor" <?= (($state ?? '') === 'johor') ? 'selected' : '' ?>>Johor</option>
                    <option value="selangor" <?= (($state ?? '') === 'selangor') ? 'selected' : '' ?>>Selangor</option>
                    <option value="kuantan" <?= (($state ?? '') === 'kuantan') ? 'selected' : '' ?>>Kuantan</option>
                    <option value="melaka" <?= (($state ?? '') === 'melaka') ? 'selected' : '' ?>>Melaka</option>
                </select>
                <label for="state">State</label>
                <div class="message"><?= $errors['state'] ?? '' ?></div>
            </div>
        </div>
    </div>

    <div class="form-box">
        <input type="text" id="phone" name="phone" 
               value="<?= htmlspecialchars($phone ?? '') ?>" placeholder="" />
        <label for="phone">Phone</label>
        <div class="message"><?= $errors['phone'] ?? '' ?></div>
    </div>

    <div class="checkbox">
        <label><input type="checkbox"> Save this information for next time</label>
    </div>

    <div class="payment-section">
        <h2>Payment</h2>
        <p>All transactions are secure and encrypted</p>
        <div class="box payment box">
            <div class="payment-row">
                <p>Omise Payments</p>
                <div class="payment-right">
                    <img src="visa.jpg" alt="visa card" width="40px">
                    <img src="mastercard.jpg" alt="mastercard" width="40px">
                </div>
            </div>
        </div>
        <div class="payment-desc">
            <p>After clicking “Pay now”, you will be redirected to Omise Payments to complete your purchase securely.</p>
        </div>
    </div>

    <div class="shipping-detail">
        <h2>Shipping Fee</h2>
        <div class="box payment box">
            <div class="payment-row">
                <label>
                    <input type="radio" name="shipping" value="west-shipping" 
                           <?= (($shipping ?? 'west-shipping') === 'west-shipping') ? 'checked' : '' ?>>
                    Peninsular Malaysia (RM4.00)
                </label>
            </div>
        </div>
        <div class="box payment box">
            <div class="payment-row">
                <label>
                    <input type="radio" name="shipping" value="north-shipping" 
                           <?= (($shipping ?? '') === 'north-shipping') ? 'checked' : '' ?>>
                    Northern Malaysia (RM8.00)
                </label>
            </div>
        </div>
    </div>

    <div class="payment-section">
        <h2>Billing address</h2>
        <div class="box payment box">
            <div class="payment-row">
                <label>
                    <input type="radio" name="billing" value="same-billing" 
                           <?= (($billingType ?? 'same-billing') === 'same-billing') ? 'checked' : '' ?>>
                    Same as shipping address
                </label>
            </div>
        </div>
        <div class="box payment box">
            <div class="payment-row">
                <label>
                    <input type="radio" name="billing" value="different-billing" 
                           <?= (($billingType ?? '') === 'different-billing') ? 'checked' : '' ?>>
                    Use a different billing address
                </label>
            </div>
        </div>

        <!-- Hidden billing form -->
        <div id="billing-form" class="<?= (($billingType ?? 'same-billing') === 'different-billing') ? '' : 'hidden' ?>">
            <div class="form-box">
                <input type="email" id="billingEmail" name="billingEmail" 
                       value="<?= htmlspecialchars($billingEmail ?? '') ?>" placeholder=" " />
                <label for="billingEmail">Email</label>
                <div class="message"><?= $errors['billingEmail'] ?? '' ?></div>
            </div>

            <div class="form-box">
                <select id="billingCountry" name="billingCountry" style="width:100%;">
                    <option value="malaysia" <?= (($billingCountry ?? '') === 'malaysia') ? 'selected' : '' ?>>Malaysia</option>
                </select>
                <label for="billingCountry">Country/Region</label>
                <div class="message"><?= $errors['billingCountry'] ?? '' ?></div>
            </div>

            <div class="form-box">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="billingFirstName" name="billingFirstName" 
                               value="<?= htmlspecialchars($billingFirstName ?? '') ?>" placeholder=" " />
                        <label for="billingFirstName">First Name</label>
                        <div class="message"><?= $errors['billingFirstName'] ?? '' ?></div>
                    </div>
                    <div class="form-group">
                        <input type="text" id="billingLastName" name="billingLastName" 
                               value="<?= htmlspecialchars($billingLastName ?? '') ?>" placeholder=" " />
                        <label for="billingLastName">Last Name</label>
                        <div class="message"><?= $errors['billingLastName'] ?? '' ?></div>
                    </div>
                </div>
            </div>

            <div class="form-box" style="margin-top: 20px;">
                <input type="text" id="billingAddress" name="billingAddress" 
                       value="<?= htmlspecialchars($billingAddress ?? '') ?>" placeholder=" " />
                <label for="billingAddress">Address</label>
                <div class="message"><?= $errors['billingAddress'] ?? '' ?></div>
            </div>

            <div class="form-box">
                <input type="text" id="billingApartment" name="billingApartment" 
                       value="<?= htmlspecialchars($billingApartment ?? '') ?>" placeholder="" />
                <label for="billingApartment">Apartment, suite, etc. (optional)</label>
                <div class="message"><?= $errors['billingApartment'] ?? '' ?></div>
            </div>

            <div class="form-box">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="billingPostcode" name="billingPostcode" 
                               value="<?= htmlspecialchars($billingPostcode ?? '') ?>" placeholder="" />
                        <label for="billingPostcode">Postcode</label>
                        <div class="message"><?= $errors['billingPostcode'] ?? '' ?></div>
                    </div>
                    <div class="form-group">
                        <input type="text" id="billingCity" name="billingCity" 
                               value="<?= htmlspecialchars($billingCity ?? '') ?>" placeholder="" />
                        <label for="billingCity">City</label>
                        <div class="message"><?= $errors['billingCity'] ?? '' ?></div>
                    </div>
                    <div class="form-group">
                        <select id="billingState" name="billingState">
                            <option value="johor" <?= (($billingState ?? '') === 'johor') ? 'selected' : '' ?>>Johor</option>
                            <option value="selangor" <?= (($billingState ?? '') === 'selangor') ? 'selected' : '' ?>>Selangor</option>
                            <option value="kuantan" <?= (($billingState ?? '') === 'kuantan') ? 'selected' : '' ?>>Kuantan</option>
                            <option value="melaka" <?= (($billingState ?? '') === 'melaka') ? 'selected' : '' ?>>Melaka</option>
                        </select>
                        <label for="billingState">State</label>
                        <div class="message"><?= $errors['billingState'] ?? '' ?></div>
                    </div>
                </div>
            </div>

            <div class="form-box">
                <input type="text" id="billingPhone" name="billingPhone" 
                       value="<?= htmlspecialchars($billingPhone ?? '') ?>" placeholder="" />
                <label for="billingPhone">Phone</label>
                <div class="message"><?= $errors['billingPhone'] ?? '' ?></div>
            </div>
        </div>
    </div>

    <div>
        <button type="submit" name="pay_now" class="pay-button">Pay Now</button>
    </div>
    <hr style="margin: 50px 0">

</form>
