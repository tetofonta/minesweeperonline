<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Game Ended.</h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-content p-3 d-flex justify-content-center align-items-center">
                <div class="d-flex w-25 h-25" style="max-height: 150px; max-width: 150px; min-height: 80px; min-width: 80px">
                    @include('partial.mascot', ["id" => "mascotEndGame"])
                </div>

                <h6 class="pt-2">Game result: <span id="points">+0</span></h6>
                <h6 class="pt-2">Standings: #<span id="pos"></span></h6>
                <h6>Time: <span id="time">00:00</span></h6>

                <div class="d-flex align-items-center justify-content-around w-100">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i> Close</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newgame-dialog" aria-label="Close"><i class="fa-solid fa-rotate-right"></i> Rematch</button>
                </div>
            </div>
        </div>
    </div>
</div>
