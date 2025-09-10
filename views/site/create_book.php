<br>
<div class="login-container">
    <h2>Создание книги</h2>
    <form id="loginForm" method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="input-group">
            <input type="text" name="title" placeholder="введите заголовок..." value="<?= $old['title'] ?? '' ?>">
        </div>
        <div class="input-group">
            <input type="text" name="year_publication" placeholder="введите год публикации..." value="<?= $old['year_publication'] ?? '' ?>">
        </div>
        <div class="input-group">
            <input type="text" name="price" placeholder="введите цену..." value="<?= $old['price'] ?? '' ?>">
        </div>
        <div class="input-group">
            <label for="author">Автор:</label>
            <select id="author" name="author_id">
                <?php
                foreach ($authors as $author) {
                    echo '<option value="' . $author->id . '">' . $author->last_name . ' ' . $author->first_name . ' ' . $author->patronym ?: ' ' . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="input-group">
            <label for="annotation">Аннотация:</label>
            <textarea id="annotation" name="annotation" ">

            </textarea>
        </div>
        <div class="input-group">
            <label>Это новое издание:</label>
            <label>
                <input type="radio" name="new_edition" value="1"> Да
            </label>
            <label>
                <input type="radio" name="new_edition" value="0" checked> Нет
            </label>
        </div>

        <div class="divider"></div>
        <button type="submit">Создать</button>
        <a href="<?= app()->route->getUrl('/books') ?>">Отмена</a>
    </form>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $field => $fieldErrors): ?>
                    <?php foreach ($fieldErrors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>