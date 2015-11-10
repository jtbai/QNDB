<?PHP

foreach (glob("helper/DAL/*.php") as $filename) {
    include $filename;
}

foreach (glob("helper/*.php") as $filename) {
    include $filename;
}
foreach (glob("model/*.php") as $filename) {
    include $filename;
}

foreach (glob("controller/*.php") as $filename) {
    include $filename;
}

