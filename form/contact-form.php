<div id="cf-mess" class="d-none">
    <div class="p-2 mb-4 rounded-md" style="background: linear-gradient(90deg, rgb(94, 199, 42) 0%, rgb(94, 199, 42) 100%);font-size: 10px;">
        <div class=""> <h5 class="text-white">Thank you for submitting the form.</h5></div>
    </div>
</div>

<form method="post" id="contactForm">
    <div class="row row-gutter-15">
        <div class="col-md-6 form-group">
            <input type="text" class="form-control" placeholder="Company" name="company" id="company" value="">

        </div>
        <div class="col-md-6 form-group">
            <input type="text" class="form-control" placeholder="Name *" name="name" id="name" value="" required >
            <span class="input-error">Name is required!</span>
        </div>
        <div class="col-md-6 form-group">
            <input type="text" class="form-control" placeholder="Phone" name="phone" id="phone" value="">

        </div>
        <div class="col-md-6 form-group">
            <input type="email" class="form-control" placeholder="Email *" name="email" id="email" value="" required >
            <span class="input-error">Email is required!</span>
        </div>

        <div class="col-lg-12 form-group">
            <textarea class="form-control" placeholder="Message *" name="message" id="message" required ></textarea>
            <span class="input-error">Message is required!</span>
        </div>


        <div class="col-lg-12 form-group">
            <label class="agreement">
                <input type="checkbox" name="accept" value="1" required  >
                <span class="input-error">You must agree to the terms!</span>
                By checking this box, I agree that the information entered will be kept and used by this site.

        </div>
    </div>
    <div class="form-footer">
        <div class=" text-center text-md-left mb-5 mb-md-5">*
            Required fields</div>
        <div class="form-action ml-md-3 ml-xl-4">
            <input type="submit" value="Submit" class="btn btn-danger"
                   id="submit-cnt-form" name="submit">
        </div>
    </div>
</form>