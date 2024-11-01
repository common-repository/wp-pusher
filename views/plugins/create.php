<h2>Install New Plugin</h2>

<form action="" method="POST">
    <input type="hidden" name="wppusher[action]" value="install-plugin">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label>Plugin repository</label>
                </th>
                <td>
                    <input name="wppusher[repository]" type="text" class="regular-text" value="<?php echo (isset($_POST['wppusher']['repository'])) ? $_POST['wppusher']['repository'] : ''; ?>">
                    <p class="description">Example: petersuhm/akismet</p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label>Repository host</label>
                </th>
                <td>
                    <select name="wppusher[type]">
                        <option value="gh" <?php if (isset($_POST['wppusher']['type']) && $_POST['wppusher']['type'] === 'gh') echo 'selected="selected" '; ?>>GitHub</option>
                        <option value="bb" <?php if (isset($_POST['wppusher']['type']) && $_POST['wppusher']['type'] === 'bb') echo 'selected="selected" '; ?>>Bitbucket</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td>
                    <label><input type="checkbox" name="wppusher[private]" <?php if (isset($_POST['wppusher']['private'])) echo 'checked'; ?>> Repository is private</label>
                </td>
            </tr>
        </tbody>
    </table>
    <?php submit_button('Install plugin'); ?>
</form>
