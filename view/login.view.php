<div class="container d-flex justify-content-center">

	<div class="row w-100">
		<!-- logo name -->
		<div class="col-md-6 col-sm-12 align-self-center">
			<div class="text-center">
				<h1 class="fw-bold fs-2" style="font-family: FreeSans !important;">Online Exam System</h1>
				<h1 class="logo fw-bold">LOGO</h1>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 d-flex flex-column justify-content-center align-items-center">
			<!-- login form -->
			<div class="text-center">
				<form action="./controller/loginController.php" method="POST" class="p-4 rounded-3 shadow"
					style="background-color: #fff !important; max-width: 300px !important;">
					<div class="mb-3">
						<input name="email" type="email" class="form-control fs-6" aria-describedby="emailHelp"
							placeholder="Email or Username" required>
					</div>
					<div class="mb-3">
						<input name="password" type="password" class="form-control fs-6 " placeholder="Password" required>
					</div>

					<button type="submit" class="btn btn-md w-100 fs-6 mb-3 fw-bold text-uppercase login_submit">Submit</button>

					<div class="text-center mb-3">
						<a href="" class="text-decoration-none">Forgot Password?</a>
					</div>

					<button data-bs-toggle="modal" data-bs-target="#signupModal" type="button"
						class="btn btn-md w-100 fs-6 mb-3 create_btn">Create
						new account</button>

					<p class="text-danger text-center fw-bold"><?php echo $err ?></p>
				</form>

				<p class="mt-4"><span class="mt-sm-2 mb-sm-4 m-md-0 fw-bold">Create exams</span> for school or business</p>
			</div>

			<!-- signup modal popup-->
			<div class="modal" tabindex="-1" id="signupModal">
				<div class="modal-dialog modal-dialog-centered">

					<div class="modal-content">
						<div class="modal-header d-flex flex-column">
							<div class="d-flex justify-content-between w-100">
								<h5 class="modal-title fw-bold fs-2">Sign Up</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<small class="text-start w-100 text-muted fs-6">It's quick and easy!</small>
						</div>

						<div class="modal-body mt-2">
							<form class="row g-3" action="./controller/signUpController.php" method="POST">
								<div class="col-md-6">
									<input name="firstname" type="text" class="form-control fs-6" placeholder="First name" required>
								</div>
								<div class="col-md-6">
									<input name="lastname" type="lastname" class="form-control fs-6" placeholder="Last name" required>
								</div>
								<div class="col-12">
									<input name="email" type="email" class="form-control fs-6" placeholder="Email address" required>
								</div>
								<div class="col-12">
									<input name="password" type="password" class="form-control fs-6" placeholder="New password" required>
								</div>
								<div class="col-md-12">
									<input name="schoolname" type="text" class="form-control fs-6" placeholder="School Name" required>
								</div>
								<div class="col-md-12">
									<input name="address" type="text" class="form-control fs-6" placeholder="Address" required>
								</div>
								<input type="submit" class="hidden_signup_btn" />
							</form>
						</div>

						<div class="modal-footer mt-2">
							<div class="col-12 text-center">
								<button id="submitBtn" type="submit" class="btn fs-6 fw-bold px-4 signup_btn">Sign Up</button>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- end of col -->
		</div>

		<!-- end of row -->
	</div>
	<!-- end of container -->
</div>

<!-- scripts -->
<script>
const submitBtn = document.querySelector("#submitBtn")
const submitBtnHidden = document.querySelector(".hidden_signup_btn")
submitBtn.addEventListener("click", (e) => {
	e.preventDefault()
	submitBtnHidden.click();
});
</script>