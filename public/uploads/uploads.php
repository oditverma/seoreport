<html>
    <head>
        <title>Tri-c Converter</title>

        <script language="JavaScript" type="text/javascript">

            function numbersonly(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;

                //if the key isn't the backspace key (which we should allow)
                if (unicode !== 8 || unicode !== 9) {
                    //if not a number
                    if (unicode < 48 || unicode > 57) {
                        if (unicode === 46) {
                            //enable key press for period
                            return true;
                        } else {
                            //disable key press
                            return false;
                        }
                    } else {
                        //enable keypress
                        return true;
                    }
                } else {
                    // enable keypress
                    return true;
                }
            }
            function block_hideshow(obj, act) {
                if (document.getElementById && document.getElementById(obj)) { // is W3C-DOM
                    if (act === 'show') {
                        document.getElementById(obj).style.display = '';
                        document.getElementById(obj).style.visibility = 'visible';
                    }
                    if (act === 'hide') {
                        document.getElementById(obj).style.display = 'none';
                        document.getElementById(obj).style.visibility = 'hidden';
                    }
                }
                else if (document.all) { // is IE
                    if (act === 'show')
                        eval("document.all." + obj + ".style.display='block'; document.all." + obj + ".style.visibility='visible';");
                    if (act === 'hide')
                        eval("document.all." + obj + ".style.display='none'; document.all." + obj + ".style.visibility='hidden';");
                }
                else if (document.layers) { // is NS
                    if (act === 'show')
                        eval("document.layers['" + id + "'].visibility='show';");
                    if (act === 'hide')
                        eval("document.layers['" + id + "'].visibility='hide';");
                }
            }

            function selectShape() {
                var e = document.getElementById('shapes');
                var eSel = e.options[e.selectedIndex].value;
                if (eSel === '1' || eSel === '2') {
                    block_hideshow('squareShape', 'show');
                    block_hideshow('circleShape', 'hide');

                } else if (eSel === '3') {
                    block_hideshow('squareShape', 'hide');
                    block_hideshow('circleShape', 'show');

                } else {
                    block_hideshow('squareShape', 'hide');
                    block_hideshow('circleShape', 'hide');
                }

            }

            function loadDepth() {
                var e = document.getElementById('productUsed');
                var eSel = e.options[e.selectedIndex].value;
                var f = document.getElementById('depth');
                var ht = document.getElementById('');
                f.options.length = 1;
                if (eSel === '1') {
                    f.options[0] = new Option("4", "4", false, true);
                    f.options[1] = new Option("6", "6", false, false);
                } else if (eSel === '2') {
                    f.options[0] = new Option("6", "6", false, true);
                    f.options[1] = new Option("9", "9", false, false);
                } else if (eSel === '3') {
                    f.options[0] = new Option("2", "2", false, true);
                    f.options[1] = new Option("3", "3", false, false);
                } else if (eSel === '4') {
                    f.options[0] = new Option("1", "1", false, true);
                    f.options[1] = new Option("1.5", "1.5", false, false);
                }
            }
        </script>
    </head>
    <body>
        <div class="container">
            <form method="post" name="form" id="form" class="form-horizontal">

                <label for="productUsed">Select an Application:</label>
                <select name="productUsed" id="productUsed" class="noOutline" onchange="loadDepth();">
                    <option value="1">Tri-C PlaySurface (Bark or Nuggets) Residential </option>
                    <option value="2">Tri-C PlaySurface - Commercial</option>
                    <option value="3">Tri-C  Landscape Bark</option>
                    <option value="4">Tri-C  Arena</option>
                </select><br>

                <label for="depth">Select a Depth:</label>
                <select name="depth" id="depth"  tabindex="2">
                    <option value="4">4</option>
                    <option value="6">6</option>
                </select><label>inches</label><br>

                <label for="feet">Enter Total Square Feet (if known):</label>
                <input  type="text" name="feet" id="feet" value="" onkeypress="return numbersonly(event);">
                <br><hr>

                <b>or, Calculate SQ Feet below</b><br>

                <select name="shapes" id="shapes" onchange="selectShape();" >
                    <option value="0">Select a Shape</option>
                    <option value="1">Rectangle / Square</option>
                    <option value="2">Triangle</option>
                    <option value="3">Circle</option>
                </select>

                <div id="squareShape" style="display:none;">
                    <div>
                        <b>Enter Your Dimensions In Feet:</b>
                    </div>
                    <div>
                        <div>
                            <label for="width">Width:</label>
                        </div>
                        <div>
                            <input type="text" name="width" id="width" value="" onkeypress="return numbersonly(event);">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="height">Height:</label>
                        </div>
                        <div>
                            <input type="text" name="height" id="height" class="noOutline" value="" onkeypress="return numbersonly(event);">
                        </div>
                    </div>
                </div>
                <div id="circleShape" style="display:none;">
                    <div class="row">
                        <b>Enter Your Dimensions In Feet:</b>
                    </div>
                    <div class="row">
                        <div class="column1">
                            <label for="diameter">Diameter:</label>
                        </div>
                        <div class="column2">
                            <input type="text" name="diameter" id="diameter" class="noOutline" value="" tabindex="7" onkeypress="return numbersonly(event);">
                        </div>
                    </div>
                </div>
                <div class="row"> <img src="shapes.jpg"> </div>

                <input type="submit"/>

                <?php
                $valA = "";
                $valB = "";
                $valC = "";
                $valD = "";
                $lbs = "";
                $depth = "";
                $shapes = "";
                $valA = $_POST['feet'];
                $valB = $_POST['width'];
                $valC = $_POST['height'];
                $valD = $_POST['diameter'];
                $lbs = $_POST['productUsed'];
                $depth = $_POST['depth'];
                $shapes = $_POST['shapes'];
                if ($lbs == 3) {
                    $sqFeet = $valA;
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 23;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='1'>" . round($totalLBs) . " lbs = " . $totalTons . " t" . "</div>");
                } elseif ($lbs !== 3) {
                    $sqFeet = $valA;
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 29;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='2'>" . round($totalLBs) . " lbs = " . $totalTons . " t" . "</div>");
                }
                if ($shapes == 1 && $lbs != 3) {
                    $sqFeet = $valB * $valC;
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 29;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='4'>" . round($totalLBs) . " lbs = " . $totalTons . " t" . "</div>");
                } elseif ($shapes == 1 && $lbs == 3) {
                    $sqFeet = $valB * $valC;
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 23;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='3'>" . round($totalLBs) . " lbs = " . $totalTons . " t" . "</div>");
                }
                if ($shapes == 2 && $lbs != 3) {
                    $sqFeet = ($valB * $valC) * 1 / 2;
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 29;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='4'>" . round($totalLBs) . " lbs = " . $totalTons . " t" . "</div>");
                } elseif ($shapes == 2 && $lbs == 3) {
                    $sqFeet = ($valB * $valC) * 1 / 2;
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 23;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='4'>" . round($totalLBs) . " lbs = " . $totalTons . " t" . "</div>");
                }
                if ($shapes == 3 && $lbs == 3) {
                    $sqFeet = 22 / 7 * ($valD / 2 * $valD / 2);
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 23;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='4'>" . $totalLBs . " lbs = " . $totalTons . " t" . "</div>");
                } elseif ($shapes == 3 && $lbs != 3) {
                    $sqFeet = 22 / 7 * ($valD / 2 * $valD / 2 );
                    $sqInches = $sqFeet * 144;
                    $totalIN = $depth * $sqInches;
                    $totalFT = $totalIN / 1728;
                    $totalLBs = $totalFT * 29;
                    $totalTons = $totalLBs / 2000;
                    print("<div id='4'>" . round($totalLBs) . " lbs = " . $totalTons . " t" . "</div>");
                }
                ?>
            </form>
        </div>
    </body>
</html>