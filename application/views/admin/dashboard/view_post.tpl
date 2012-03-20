<h1>New Posts</h1>

{include file="errors.tpl"}

<div class="main">
    <div class="images">
        <img width="900" height="450" alt="catsboobs" id="catsboobs" src="/content/{$postModel->getUniqid()}.png">
    </div>
    <div class="social">
        <form action="/admin/dashboard/edit-post/" method="post">
            <input type="hidden"name="post[id]" value="{$postModel->getId()}"/>
            <select name="post[status]" style="width:200px;">
                <option value="0" {if $postModel->getStatus()==0}selected="selected"{/if}>Ждет модерации</option>
                <option value="1" {if $postModel->getStatus()==1}selected="selected"{/if}>Одобрено</option>
            </select>
            <input id="del" type="checkbox" name="post[delete]" style="vertical-align: top; margin-left: 20px;"/>
            <label for="del">Удалить</label>
            <input type="submit" value="Сохранить"/>
        </form>
    </div>
</div>