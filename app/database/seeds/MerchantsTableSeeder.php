<?php

class MerchantsTableSeeder extends Seeder {

	public function run()
	{
		$merchants = array(
		 		array('name' => 'AbeBooks', 
		 					'slug' => 'abebooks', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/abebooks.gif',
		 					'description' => 'AbeBooks is an online marketplace for books. Millions of books offered from thousands of booksellers around the world are for sale through the AbeBooks website.'),
		 		array('name' => 'Amazon', 
		 					'slug' => 'amazon', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/amazon.gif', 
		 					'aff_code' => 'recycleabook-20',
		 					'description' => 'Rent textbooks and save up to 70% off new print. You can keep your textbooks for a semester, and when it comes time to send your books back, Amazon pays for return shipping.'),
		 		array('name' => 'BiggerBooks.com', 
		 					'slug' => 'biggerbooks', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/biggerbooks.gif',
		 					'description' => 'BiggerBooks offers a wide selection of new and used books and partners with the largest publishers and distribution centers to offer cheap prices.'),
		 		array('name' => 'Barnes & Noble', 
		 					'slug' => 'bn', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/bn.gif', 
		 					'description' => 'Barnes and Nobles is known for the excellence in customer service, and huge inventory. The B&N marketplace offers millions of new and used textbooks from many trusted sellers, usually at discounted prices.'),
		 		array('name' => 'BookByte.com', 
		 					'slug' => 'bookbyte', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/bookbyte.jpg', 
		 					'description' => 'Bookbyte has been providing cheap textbooks to college students for more than a decade. Their inventory includes all subjects and used, new, and rental offerings. Free shipping on most non-marketplace orders over $49. '),
		 		array('name' => 'BookRenter.com', 
		 					'slug' => 'bookrenter', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/bookrenter.gif',
		 					'description' => 'BookRenter delivers free standard shipping both ways, a 21-day no-questions-asked rental-return policy, low prices on over 5 million textbooks, and five flexible rental periods. Write or highlight in your rentals.'),
		 		array('name' => 'Bookstores.com', 
		 					'slug' => 'bookstores', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/bookstorescom.gif', 
		 					'description' => 'Bookstores.com is an marketplace online where book buyers and sellers can connect safely and securely. Bookstores.com is dedicated to creating a safe and reputable venue for customers to buy and sell books. They back this buy having a 14 day guarantee on the condition of every item described in their marketplace.'),
		 		array('name' => 'CampusBookRentals.com', 
		 					'slug' => 'campusbookrentals', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/campusbookrentals.jpg',
		 					'description' => 'CampusBookRentals.com began renting textbooks in 2007. Since then, they\'ve served thousands of students on more than 5,000 different college campuses. Every rental comes with a worry-free guarantee that allows you to return your book within the first 30 days of your order. Free shipping both ways. '),
		 		array('name' => 'Chegg', 
		 					'slug' => 'chegg', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/chegg120x30.png',
		 					'description' => 'Chegg is the number-one provider of textbook rentals. The company has been helping college students get cheap textbooks for years. All rentals come with a 21-day Satisfaction Guarantee, 14 days for eTextbooks.'),
		 		array('name' => 'CourseSmart', 
		 					'slug' => 'coursesmart', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/coursesmart.gif',
		 					'description' => 'Study smarter with eTextbooks and eResources from CourseSmart, and save up to 60% off the price of print textbooks.'),
		 		array('name' => 'Ebay', 
		 					'slug' => 'ebay', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/ebay.jpg',
		 					'description' => 'With more than 100 million active users globally, eBay is the world\'s largest online marketplace, where practically anyone can buy and sell practically anything. With auctions, you set your price and you can save a bundle.'),
		 		array('name' => 'eCampus', 
		 					'slug' => 'ecampus', 
		 					'logo_url' => 'http://www.campusbooks.com/images/markets/ecampus.gif',
		 					'description' => ' The Rent and Return Program by eCampus.com is a low-cost alternative to purchasing textbooks. You don\'t own the book, you are simply borrowing it from eCampus.com for a fee and returning it at the end of the rental term you selected.'),
				array('name' => 'Half.com', 
							'slug' => 'half', 
							'logo_url' => 'http://www.campusbooks.com/images/markets/half_logo.jpg',
							'description' => 'Buying textbooks on Half.com can offer great savings. Often Half.com offers older editions of textbooks at a substantial discount. When you find the textbook you\'re looking for, click "See Other Editions" to see if there are older versions offered at better prices. Before you buy, you might want to confirm with your instructor to make sure an older edition is acceptable for the course. Sometimes older editions will have different exercises or may be missing chapters. If you\'re in doubt, purchase the correct edition and you\'ll still save a lot of money. If you need your book in a hurry, be sure to choose Expedited Mail as the method of shipment. The default method, Media Mail, can take as many as 14 days for delivery. '),
				array('name' => 'KnetBooks', 
							'slug' => 'knetbooks', 
							'logo_url' => 'http://www.campusbooks.com/images/markets/knetbooks.gif',
							'description' => 'KnetBooks offers free shipping both ways as well as the option to rent your textbooks for different periods of time in order to better accommodate your needs. If you decide that you need to keep your book rental for a longer period, you can add 15 or 30 days for a small fee. Most rentals ship within 48 hours. Once you receive the rented textbook, keep the box so you can reuse it when you ship your textbook back for free. '),
				array('name' => 'TextBooksRUs.com', 
							'slug' => 'textbooksrus', 
							'logo_url' => 'http://www.campusbooks.com/images/markets/textbooksrus.gif', 
							'description' => 'TextbooksRus.com has been in operation since 2002 but has been in the book business for over 15 years. They offer a massive inventory of domestic and international editions and multiple shipping options. Free shipping on most non-marketplace orders over $49.'),
				array('name' => 'TextBookX.com', 
							'slug' => 'textbookx', 
							'logo_url' => 'http://www.campusbooks.com/images/markets/TextBookXlogo.gif',
							'description' => 'TextbookX.com offers new, used, and digital textbooks as well as rentals. Free shipping on most non-marketplace orders over $49.'),
				array('name' => 'ValoreBooks', 
							'slug' => 'valore', 
							'logo_url' => 'http://www.campusbooks.com/images/markets/valoremarketplace.gif',
							'description' => 'Valore rental books are an affordable and eco-friendly option. Valore offers expedited shipping to you when you need books ASAP and they pay for the return shipping when you are done with the books. ')
		);

		DB::table('merchants')->delete();

		foreach($merchants as $merchant){
			DB::table('merchants')->insert($merchant);
		}
		
		
	}

}
