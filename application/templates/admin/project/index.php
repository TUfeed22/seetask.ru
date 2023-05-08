<section class="section">
	<duv class="card">
		<div class="card-body">
			<button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#xlarge">
				Создать
			</button>
		</div>
	</duv>

	<div class="modal fade text-left w-100" id="xlarge" tabindex="-1" aria-labelledby="myModalLabel16" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel16">
						Новый проект
					</h4>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
					</button>
				</div>
				<div class="modal-body">
          <section id="multiple-column-form">
            <div class="row match-height">
              <div class="col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <form class="form">
                        <div class="row">
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="first-name-column">First Name</label>
                              <input
                                  type="text"
                                  id="first-name-column"
                                  class="form-control"
                                  placeholder="First Name"
                                  name="fname-column"
                              />
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="last-name-column">Last Name</label>
                              <input
                                  type="text"
                                  id="last-name-column"
                                  class="form-control"
                                  placeholder="Last Name"
                                  name="lname-column"
                              />
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="city-column">City</label>
                              <input
                                  type="text"
                                  id="city-column"
                                  class="form-control"
                                  placeholder="City"
                                  name="city-column"
                              />
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="country-floating">Country</label>
                              <input
                                  type="text"
                                  id="country-floating"
                                  class="form-control"
                                  name="country-floating"
                                  placeholder="Country"
                              />
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="company-column">Company</label>
                              <input
                                  type="text"
                                  id="company-column"
                                  class="form-control"
                                  name="company-column"
                                  placeholder="Company"
                              />
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="email-id-column">Email</label>
                              <input
                                  type="email"
                                  id="email-id-column"
                                  class="form-control"
                                  name="email-id-column"
                                  placeholder="Email"
                              />
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">
						<i class="bx bx-x d-block d-sm-none"></i>
						<span class="d-none d-sm-block">Отмена</span>
					</button>
					<button type="button" class="btn btn-success ml-1" data-bs-dismiss="modal">
						<i class="bx bx-check d-block d-sm-none"></i>
						<span class="d-none d-sm-block">Сохранить</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
<?= $table; ?>