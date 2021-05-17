<!-- Modal -->
<div class="modal fade" id="modal-forget-pwd" tabindex="-1" aria-labelledby="modal-forget-pwd-label" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-forget-pwd"><b>Mot de passe oublié ?</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?page=login" method="POST">
                <div class="modal-body pb-5">
                    <label>Saisissez l'adresse e-mail associée à votre compte. Nous vous enverrons un lien par e-mail pour réinitialiser votre mot de passe.</label>
                    <div class="form-group"><input class="form-control form-control-user" type="email" id="EmailLoginInput" aria-describedby="emailHelp" placeholder="Adresse e-mail" name="email-forget-pwd"></div>
                </div>
                <div class="modal-footer">
                    <div class="d-grid mx-auto">
                        <button style="width: 450px;" type="submit" class="btn btn-primary" name="submit-forget-pwd">Envoyer le lien</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>