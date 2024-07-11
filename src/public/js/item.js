    document.getElementById('show-items').addEventListener('click', function(){
        document.getElementById('item-list').classList.remove('hidden');
        if (document.getElementById('likes-list')) {
            document.getElementById('likes-list').classList.add('hidden');
        }
        document.getElementById('available-list').classList.add('hidden');

        document.getElementById('show-items').classList.add('selected');
        if (document.getElementById('show-likes')) {
            document.getElementById('show-likes').classList.remove('selected');
        }
        document.getElementById('show-available').classList.remove('selected');
    });

    if (document.getElementById('show-likes')) {
        document.getElementById('show-likes').addEventListener('click', function(){
            document.getElementById('item-list').classList.add('hidden');
            document.getElementById('likes-list').classList.remove('hidden');
            document.getElementById('available-list').classList.add('hidden');

            document.getElementById('show-items').classList.remove('selected');
            document.getElementById('show-likes').classList.add('selected');
            document.getElementById('show-available').classList.remove('selected');
        });
    }

    document.getElementById('show-available').addEventListener('click', function(){
        document.getElementById('item-list').classList.add('hidden');
        if (document.getElementById('likes-list')) {
            document.getElementById('likes-list').classList.add('hidden');
        }
        document.getElementById('available-list').classList.remove('hidden');

        document.getElementById('show-items').classList.remove('selected');
        if (document.getElementById('show-likes')) {
            document.getElementById('show-likes').classList.remove('selected');
        }
        document.getElementById('show-available').classList.add('selected');
    });