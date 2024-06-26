"use strict";

import { validateEmail, showErr, removeErr } from './utils.js';
const email_el        = document.querySelector("#email");
const name_el         = document.querySelector("#customer-name");
const password_el     = document.querySelector("#password");
const password_err    = document.querySelector(".password-err");
const wrong_pass_err  = document.querySelector(".wrong-pass-err");
const serv_err        = document.querySelector(".servr-err");
const email_err       = document.querySelector(".email-err");
const next_btn        = document.getElementById("sign-up");
const signinBtn       = document.getElementById("signin-button");

next_btn.addEventListener("click", async(e) => {
  e.preventDefault();
  next_btn.disabled = true;
  removeErr(password_err, password_el);
  removeErr(email_err, email_el);
  const email = email_el.value;
  const name = name_el.value;
  const password = password_el.value;
  if (!validateEmail(email)){
    showErr(email_err, email_el);
    return;
  }
  if (!password || password.length < 8) {
    showErr(password_err, password_el);
    return;
  }
  if (!name) {
    return;
  } 
  try {
    const response = await fetch('/signup', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        email: email,
        name: name,
        password: password,
      }),
    });
    
    const result = await response.json();
    
    if (response.ok) {
      window.location.href = '/signin';
    } else {
      // Handle server-side validation errors
      if (result.errors) {
        result.errors.forEach(err => {
          if (err.param === 'email') {
            showErr(email_err, email_el);
          }
          if (err.param === 'password') {
            showErr(password_err, password_el);
          }
          if (err.param === 'name') {
            showErr(name_err, name_el);
          }
        });
      }
    }
  } catch (error) {
    console.error('Error:', error);
  } finally {
    next_btn.disabled = false;
  }
});