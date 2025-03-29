<x-app-layout>
    <div style="color: white; padding: 20px;">
        <!-- Section explicative -->
        <div style="background-color: rgba(0,0,0,0.5); padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <h1>Résultat du Filtrage</h1>
            <p>
                Résultat du filtrage des données. Les enregistrements "OK" (conformes) sont ceux qui ne contiennent pas de code malicieux,
                tandis que les enregistrements "KO" (rejetés) contiennent des éléments suspects.
            </p>
        </div>

        <!-- Affichage du message résumé -->
        <div>{!! $message !!}</div>

        <!-- Liste déroulante pour choisir l'affichage -->
        <div style="margin: 20px 0;">
            <label for="filterSelect" style="font-size: 1em; color: white;">Choisissez ce que vous souhaitez afficher :</label>
            <select id="filterSelect" onchange="filterData(this.value)" style="padding: 10px; font-size: 1em; margin-left: 10px; color: black;">
                <option value="ideas-ok">Idées OK</option>
                <option value="ideas-ko">Idées KO</option>
                <option value="comments-ok">Commentaires OK</option>
                <option value="comments-ko">Commentaires KO</option>
            </select>
        </div>

        <!-- Section pour les Idées OK -->
        <div id="ideasOkSection">
            <h2>Idées OK</h2>
            <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($validIdeas as $idea)
                    <tr>
                        <td>{{ $idea->title }}</td>
                        <td>{{ $idea->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section pour les Idées KO -->
        <div id="ideasKoSection" style="display: none;">
            <h2>Idées KO</h2>
            <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invalidIdeas as $idea)
                    <tr>
                        <td>{{ $idea->title }}</td>
                        <td>{{ $idea->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section pour les Commentaires OK -->
        <div id="commentsOkSection" style="display: none;">
            <h2>Commentaires OK</h2>
            <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <thead>
                    <tr>
                        <th>Contenu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($validComments as $comment)
                    <tr>
                        <td>{{ $comment->content }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section pour les Commentaires KO -->
        <div id="commentsKoSection" style="display: none;">
            <h2>Commentaires KO</h2>
            <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <thead>
                    <tr>
                        <th>Contenu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invalidComments as $comment)
                    <tr>
                        <td>{{ $comment->content }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script pour basculer entre les sections -->
    <script>
        function filterData(choice) {
            // Masquer toutes les sections
            document.getElementById('ideasOkSection').style.display = 'none';
            document.getElementById('ideasKoSection').style.display = 'none';
            document.getElementById('commentsOkSection').style.display = 'none';
            document.getElementById('commentsKoSection').style.display = 'none';

            // Afficher la section correspondant au choix
            if (choice === 'ideas-ok') {
                document.getElementById('ideasOkSection').style.display = 'block';
            } else if (choice === 'ideas-ko') {
                document.getElementById('ideasKoSection').style.display = 'block';
            } else if (choice === 'comments-ok') {
                document.getElementById('commentsOkSection').style.display = 'block';
            } else if (choice === 'comments-ko') {
                document.getElementById('commentsKoSection').style.display = 'block';
            }
        }
    </script>
</x-app-layout>