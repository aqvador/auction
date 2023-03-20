<?php
/**
 * @var \App\infrastructure\repository\entities\Lot $lot
 * @var  \App\infrastructure\repository\entities\User $currentUser
 */

?>
<hr>
Текущий выигрыш: <?= $lot->getStep()->getAmountWin()->toFloat() ?> <br>
Текущий пользователь: <?= $currentUser->getName() ?> <br>
<hr>
<form action="/auction/v1/betting/<?= $lot->getUuid()->toString() ?>" method="POST">
    <div class="form-example">
        <input type="text" name="betting_user" hidden="hidden" value="<?= $currentUser->getUuid()->toString() ?>">
        <input type="submit" value="Сделать следующую ставку">
    </div>
</form>

<hr>
<a href="/auction/v1/view/<?= $lot->getUuid()->toString() ?>">На страницу просмотра аукциона</a>
