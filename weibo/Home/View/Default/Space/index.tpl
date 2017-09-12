<extend name="Base/common" />

<block name="head">
    <link rel="stylesheet" href="__CSS__/space.css">
</block>

<block name="main">
    <div class="main_left">
        <div class="header">
            <dl>
                <empty name="bigFace">
                    <dt><img src="__IMG__/big.jpg" alt=""></dt>
                    <else/>
                    <dt><img src="__ROOT__/{$bigFace}" alt=""></dt>
                </empty>
                <dd class="username">{$user[0].username}</dd>
                <dd class="info">个人简介：{$user[0].extend.intro}</dd>
            </dl>
        </div>
    </div>
    <div class="main_right">
        right
    </div>
</block>