<?php
/**
 * @var \App\infrastructure\repository\entities\Lot $lot
 */

?>

<?php if ($lot->isTimeout() && $lot->getWinner()) : ?>
    <b>Аукцион закончен, происходит награждение победителей!<b>
<?php endif; ?>



<?php if (($lot->isTimeout() && !$lot->getStatus()->isFinished()) && !$lot->getWinner()) : ?>
    <b>Аукцион закончен, происходит подсчёт результатов, обновите страницу чуть позже!<b>
<?php endif; ?>

<?php if ($lot->getStatus()->isFinished() && !$lot->getWinner()) : ?>
    <b>Аукцион закончен, но победителя нет в этом аукционе!<b>
<?php endif; ?>

<?php if ($lot->getStatus()->isCreated()) : ?>
    <b>Аукцион создан, но еще не был запущен!<b>
    <form action="/auction/v1/run/<?= $lot->getUuid()->toString() ?>" method="POST">
        <div class="form-example">
            <input type="submit" value="Запустить аукцион">
        </div>
    </form>
<?php endif; ?>


<?php if ($lot->getStatus()->isRunning() && !$lot->isTimeout()) : ?>
    <b>Аукцион запущен!<b><br>
    <a href="/auction/v1/betting/<?= $lot->getUuid()->toString() ?>">Вперед к ставкам</a>
<?php endif; ?>


    <hr>
    <b>ID:</b> <?= $lot->getUuid()->toString() ?> <br>
    <b>Название:</b> <?= $lot->getName() ?><br>
    <b>Цена шага:</b><?= $lot->getStep()->getPrice()->toScale(2)->toFloat() ?><br>
    <b>Время шага:</b><?= $lot->getStep()->getTime()  ?>s.<br>
    <b>Статус:</b> <?= $lot->getStatus()->value ?><br>
    <b>Победитель:</b> <?= $lot->getWinner()?->getName() ?><br>
    <b>сумма выигрыша:</b><?= $lot->getAmountWin()->toFloat() ?><br>

    <br>