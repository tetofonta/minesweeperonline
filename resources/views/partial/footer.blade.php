<footer class="text-center text-lg-start bg text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
            <span>&copy; 2023, minesweeperonline.net</span>
        </div>

        <div>
            <a href="https://facebook.com/io.stefano" class="me-4 text-reset">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/tetofonta" class="me-4 text-reset">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com/tetofonta" class="me-4 text-reset">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="https://www.linkedin.com/in/fontana-stefano" class="me-4 text-reset">
                <i class="fa-brands fa-linkedin"></i>
            </a>
            <a href="https://github.com/tetofonta" class="me-4 text-reset">
                <i class="fa-brands fa-github"></i>
            </a>
            <a href="mailto:me@stefanofontana.it" class="me-4 text-reset">
                <i class="fa-regular fa-envelope"></i>
            </a>
        </div>
    </section>

    <section class="">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3"></i>minesweeperonline.net
                    </h6>
                    <p>
                        Compete and win playing mine sweeper. Beat the world but do not explode!
                    </p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        Links
                    </h6>
                    <p>
                        <a href="https://www.unibs.it" class="text-reset">UniBS</a>
                    </p>
                    <p>
                        <a href="https://unibs.coursecatalogue.cineca.it/insegnamenti/2020/756268/2011/1968/92" class="text-reset">Best university course ever</a>
                    </p>
                    <p>
                        <a href="https://www.php.net/" class="text-reset">Worst programming language ever</a>
                    </p>
                    <p>
                        <a href="javascript:void(0)" onclick="update_squirrel()" data-bs-target="#squirrelmodal" data-bs-toggle="modal" class="text-reset">LOOK! A Squirrel!</a>
                    </p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p><i class="fas fa-home me-3"></i> Italy, Via Branze 38, Brescia (BS)</p>
                    <p>
                        <i class="fas fa-envelope me-3"></i>
                        me@stefanofontana.com
                    </p>
                    <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                    <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                </div>
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    </div>

    <div class="modal fade" id="squirrelmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog position-relative" role="document">
            <div class="position-absolute" style="top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%); z-index: 1000">Catching the squirrell...</div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">A SQUIRRELLLL!!!</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="squirrel" style="background-position: center; background-repeat: no-repeat; background-size: cover; padding-top: 100%; z-index: 1001">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function update_squirrel(){
            const url = 'https://source.unsplash.com/random/?squirrel'
            document.getElementById('squirrel').style.backgroundImage = `url(${url}&q=${Math.random().toString(26).substring(2)})`
        }
    </script>
</footer>
<!-- Footer -->
