<!DOCTYPE html>
<html>
    <head>

        <title>DeciMill</title>

        <script type="text/javascript" src="/application/js/jquery/jquery.js"></script>
        <script type="text/javascript" src="/application/js/jquery/jquery-plugins.js"></script>
        
        <link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300" rel="stylesheet" type="text/css">
        <link type="text/css" rel="stylesheet" href="/application/layout/main.css">
        <link type="text/css" rel="stylesheet" href="/application/layout/ui.css">

    </head>

    <body>

        <div class="header">
            <img src="/application/images/logo.png" style="margin: 9px 0 0 15px;" />
        </div>

        <div style="width: 360px; margin: 50px auto 0;">

            <h1>
                Choose a Case Study
            </h1>

            <div style="background-color: #f0f1f2; border-radius: 3px; box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);">
                <div style="padding: 32px 30px;">
                    <form action="/home/select_case" method="post">
                        <select class="selectCase" name="caseId">
                            <? foreach ($cases AS $case): ?>
                            <option value="<?= $case->getId() ?>"><?= $case->getName() ?></option>
                            <? endforeach; ?>
                        </select>
                        <input class="button chooseCase" type="submit" value="Select Existing Case Study" />
                    </form>
                </div>
            </div>

            <h1 style="font-size: 22px; margin-top: 30px;">
                ...or Open a New One
            </h1>

            <div style="background-color: #f0f1f2; border-radius: 3px; box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);">
                <div style="padding: 32px 30px;">
                    <form action="/contextmanager/open_case" method="post">
                        <input type="text" name="caseName" style="box-sizing: border-box; width: 300px; font-size: 16px; padding: 7px; margin-bottom: 10px;" placeholder="New case study name..." />
                        <input type="submit" class="button openCase" value="Open New Case Study" />
                    </form>
                </div>
            </div>

        </div>

    </body>
</html>