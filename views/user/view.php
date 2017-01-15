<?php

/* @var $user \app\models\User */

?>
<div class="form-group">
    <div class="col-md-12">
        <div class="col-md-4">
            <img class="col-md-12" src="<?= \app\models\Image::getAvatar($user->avatar ? $user->avatar->path : null)?>">
        </div>
        <div class="col-md-8">
            <?php echo \yii\widgets\DetailView::widget([
                'model' => $user,
                'attributes' => [
                    'username' => [
                        'label' => 'Username',
                        'value' => $user->username
                    ],
                    'email' => [
                        'label' => 'Email',
                        'value' => $user->email
                    ],
                    'created_at:datetime',
                    'name' => [
                        'label' => 'Name',
                        'value' => $user->userData ? $user->userData->name : ''
                    ],
                    'surname' => [
                        'label' => 'Surname',
                        'value' => $user->userData ? $user->userData->surname : ''
                    ],
                    'mobile' => [
                        'label' => 'Mobile',
                        'value' => $user->userData ? $user->userData->mobile : ''
                    ],
                    'address' => [
                        'label' => 'Address',
                        'value' => $user->userData ? $user->userData->address : ''
                    ]
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-offset-11 col-lg-1">
                <?= \yii\bootstrap\Html::a('Update', ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
