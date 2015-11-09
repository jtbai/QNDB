<?PHP
include('route.php');
foreach (glob("helper/DAL/*.php") as $filename) {
    include $filename;
}

foreach (glob("helper/*.php") as $filename) {
    include $filename;
}
foreach (glob("model/*.php") as $filename) {
    include $filename;
}

foreach (glob("view/*.php") as $filename) {
    include $filename;
}
