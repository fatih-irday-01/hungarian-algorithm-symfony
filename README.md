
#### İŞ YÜKLEME

Farklı zorluklardaki işleri, farklı kabiliyetteki 
yazılımcılara atamak için en uygun algoritmanın [Macar Algoritması](https://dergipark.org.tr/tr/download/article-file/29720)
olduğunu öğrendim. Sistem bu algoritma üzerine çalışıyor.


-   ``php bin/console app:getProviders`` komutu ile uzak sunuculardan işler toplanıyor.
-   Yeni sunucu eklemek için ``/var/www/html/symfony/blog/src/Service/Providers/Packets`` klasörüne sunucudan alınan verileri filtreliyen **Class** eklenmesi gerekiyor. eklenen **Class** ise ``/var/www/html/symfony/blog/src/Service/Providers/ProviderAll.php`` içerisinde tanımlanmalı.



**_not :_** Symfony ve Hungarian Algorithm ile ilk defa çalışmış oldum. 
