<head>
    <title>Liên hệ</title>
</head>
<?php
	include('inc/header.php');
?>
<div class="row">
    <div class="col-9 mt-3">
        <h3>Liên hệ với chúng tôi!</h3>
        <p>Chúng tôi mong muốn lắng nghe từ bạn. Hãy liên hệ với chúng tôi và một thành viên của chúng tôi sẽ liên lạc
            với bạn trong thời gian sớm nhất. Chúng tôi yêu thích việc nhận được email của bạn mỗi ngày <em>mỗi
                ngày</em>.</p>
        <form>
            <div class="row mb-4">
                <div class="col-3">
                    <label class="form-label" for="name"><b>Tên của bạn</b></label>
                </div>
                <div class="col-9">
                    <input class="form-control" type="text" placeholder="Tên của bạn" />
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-3">
                    <label class="form-label" for="email"><b>Email của bạn</b></label>
                </div>
                <div class="col-9">
                    <input class="form-control" type="email" placeholder="Email của bạn" />
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-3">
                    <b><label class="form-label">Nội dung</label></b>
                </div>
                <div class="col-9">
                    <textarea class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="submit" name="submit">Liên Hệ</button>
            </div>
        </form>
    </div>
    <div class="col-3 mt-3">
        <div>
            <h5>Bản đồ</h5>
            <p>
                <a href="#">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15729855.42909206!2d96.7382165931671!3d15.735434000981483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31157a4d736a1e5f%3A0xb03bb0c9e2fe62be!2zVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1445179448264"
                        width="200" height="200" frameborder="0" style="border:0" scrolling="no" marginheight="0"
                        marginwidth="0"></iframe>
                    <br />
                </a>
                <br />
                <a href="#" style="text-decoration:none;">Xem bản đồ</a>
            </p>
            <p>
                Địa chỉ 1.
                <br />
                Địa chỉ 2.
            </p>
        </div>
    </div>

</div>
<hr />
<?php
	include('inc/footer.php');
?>