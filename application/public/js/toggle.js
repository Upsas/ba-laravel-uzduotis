function toggleModal(modalID)
{
    document.getElementById(modalID + "-backdrop").classList.toggle("flex");
    document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("flex");
}
function toggleModalShare(modalID)
{
    document.getElementById(modalID + "-backdrop").classList.toggle("flex");
    document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("flex");
}
function toggleModalDeleteConfirmation(modalID)
{

    document.getElementById(modalID).classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("fixed");
}



