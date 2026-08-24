/**
 * In Memoriam - generateur de QR code autonome.
 *
 * Implementation minimale d'ISO/IEC 18004 : mode octet, niveaux L/M/Q/H,
 * versions 1 a 20. Aucune dependance, aucun appel reseau, aucune image
 * distante : le QR est dessine dans un <canvas> par le navigateur.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */
(function (window) {
	'use strict';

	/* ------------------------------------------------------------------ *
	 * Tables de blocs Reed-Solomon : [total, donnees] pour chaque bloc.
	 * ------------------------------------------------------------------ */
	var RS_BLOCKS = {
	L: [[[26,19]],[[44,34]],[[70,55]],[[100,80]],[[134,108]],[[86,68],[86,68]],[[98,78],[98,78]],[[121,97],[121,97]],[[146,116],[146,116]],[[86,68],[86,68],[87,69],[87,69]],[[101,81],[101,81],[101,81],[101,81]],[[116,92],[116,92],[117,93],[117,93]],[[133,107],[133,107],[133,107],[133,107]],[[145,115],[145,115],[145,115],[146,116]],[[109,87],[109,87],[109,87],[109,87],[109,87],[110,88]],[[122,98],[122,98],[122,98],[122,98],[122,98],[123,99]],[[135,107],[136,108],[136,108],[136,108],[136,108],[136,108]],[[150,120],[150,120],[150,120],[150,120],[150,120],[151,121]],[[141,113],[141,113],[141,113],[142,114],[142,114],[142,114],[142,114]],[[135,107],[135,107],[135,107],[136,108],[136,108],[136,108],[136,108],[136,108]]],
	M: [[[26,16]],[[44,28]],[[70,44]],[[50,32],[50,32]],[[67,43],[67,43]],[[43,27],[43,27],[43,27],[43,27]],[[49,31],[49,31],[49,31],[49,31]],[[60,38],[60,38],[61,39],[61,39]],[[58,36],[58,36],[58,36],[59,37],[59,37]],[[69,43],[69,43],[69,43],[69,43],[70,44]],[[80,50],[81,51],[81,51],[81,51],[81,51]],[[58,36],[58,36],[58,36],[58,36],[58,36],[58,36],[59,37],[59,37]],[[59,37],[59,37],[59,37],[59,37],[59,37],[59,37],[59,37],[59,37],[60,38]],[[64,40],[64,40],[64,40],[64,40],[65,41],[65,41],[65,41],[65,41],[65,41]],[[65,41],[65,41],[65,41],[65,41],[65,41],[66,42],[66,42],[66,42],[66,42],[66,42]],[[73,45],[73,45],[73,45],[73,45],[73,45],[73,45],[73,45],[74,46],[74,46],[74,46]],[[74,46],[74,46],[74,46],[74,46],[74,46],[74,46],[74,46],[74,46],[74,46],[74,46],[75,47]],[[69,43],[69,43],[69,43],[69,43],[69,43],[69,43],[69,43],[69,43],[69,43],[70,44],[70,44],[70,44],[70,44]],[[70,44],[70,44],[70,44],[71,45],[71,45],[71,45],[71,45],[71,45],[71,45],[71,45],[71,45],[71,45],[71,45],[71,45]],[[67,41],[67,41],[67,41],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42],[68,42]]],
	Q: [[[26,13]],[[44,22]],[[35,17],[35,17]],[[50,24],[50,24]],[[33,15],[33,15],[34,16],[34,16]],[[43,19],[43,19],[43,19],[43,19]],[[32,14],[32,14],[33,15],[33,15],[33,15],[33,15]],[[40,18],[40,18],[40,18],[40,18],[41,19],[41,19]],[[36,16],[36,16],[36,16],[36,16],[37,17],[37,17],[37,17],[37,17]],[[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[44,20],[44,20]],[[50,22],[50,22],[50,22],[50,22],[51,23],[51,23],[51,23],[51,23]],[[46,20],[46,20],[46,20],[46,20],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21]],[[44,20],[44,20],[44,20],[44,20],[44,20],[44,20],[44,20],[44,20],[45,21],[45,21],[45,21],[45,21]],[[36,16],[36,16],[36,16],[36,16],[36,16],[36,16],[36,16],[36,16],[36,16],[36,16],[36,16],[37,17],[37,17],[37,17],[37,17],[37,17]],[[54,24],[54,24],[54,24],[54,24],[54,24],[55,25],[55,25],[55,25],[55,25],[55,25],[55,25],[55,25]],[[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[43,19],[44,20],[44,20]],[[50,22],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23],[51,23]],[[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[50,22],[51,23]],[[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[47,21],[48,22],[48,22],[48,22],[48,22]],[[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[54,24],[55,25],[55,25],[55,25],[55,25],[55,25]]],
	H: [[[26,9]],[[44,16]],[[35,13],[35,13]],[[25,9],[25,9],[25,9],[25,9]],[[33,11],[33,11],[34,12],[34,12]],[[43,15],[43,15],[43,15],[43,15]],[[39,13],[39,13],[39,13],[39,13],[40,14]],[[40,14],[40,14],[40,14],[40,14],[41,15],[41,15]],[[36,12],[36,12],[36,12],[36,12],[37,13],[37,13],[37,13],[37,13]],[[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[44,16],[44,16]],[[36,12],[36,12],[36,12],[37,13],[37,13],[37,13],[37,13],[37,13],[37,13],[37,13],[37,13]],[[42,14],[42,14],[42,14],[42,14],[42,14],[42,14],[42,14],[43,15],[43,15],[43,15],[43,15]],[[33,11],[33,11],[33,11],[33,11],[33,11],[33,11],[33,11],[33,11],[33,11],[33,11],[33,11],[33,11],[34,12],[34,12],[34,12],[34,12]],[[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[37,13],[37,13],[37,13],[37,13],[37,13]],[[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[36,12],[37,13],[37,13],[37,13],[37,13],[37,13],[37,13],[37,13]],[[45,15],[45,15],[45,15],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16],[46,16]],[[42,14],[42,14],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15]],[[42,14],[42,14],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15]],[[39,13],[39,13],[39,13],[39,13],[39,13],[39,13],[39,13],[39,13],[39,13],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14],[40,14]],[[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[43,15],[44,16],[44,16],[44,16],[44,16],[44,16],[44,16],[44,16],[44,16],[44,16],[44,16]]],
	};

	/* ------------------------------------------------------------------ *
	 * Arithmetique dans GF(256), polynome generateur 0x11D.
	 * ------------------------------------------------------------------ */
	var EXP = new Array(512), LOG = new Array(256);

	(function initGaloisField() {
		var x = 1, i;

		for (i = 0; i < 255; i++) {
			EXP[i] = x;
			LOG[x] = i;
			x <<= 1;

			if (x & 0x100) {
				x ^= 0x11D;
			}
		}

		for (i = 255; i < 512; i++) {
			EXP[i] = EXP[i - 255];
		}
	}());

	function gfMul(a, b) {
		if (a === 0 || b === 0) {
			return 0;
		}

		return EXP[LOG[a] + LOG[b]];
	}

	/**
	 * Polynome generateur de degre `degree`.
	 */
	function rsGenerator(degree) {
		var poly = [1], i, j, next;

		for (i = 0; i < degree; i++) {
			next = poly.slice();
			next.push(0);

			for (j = 0; j < poly.length; j++) {
				next[j + 1] ^= gfMul(poly[j], EXP[i]);
			}

			poly = next;
		}

		return poly;
	}

	/**
	 * Codewords de correction d'erreur pour un bloc de donnees.
	 */
	function rsEncode(data, ecCount) {
		var gen = rsGenerator(ecCount),
			rem = new Array(ecCount).fill(0),
			i, j, factor;

		for (i = 0; i < data.length; i++) {
			factor = data[i] ^ rem[0];
			rem.shift();
			rem.push(0);

			for (j = 0; j < ecCount; j++) {
				rem[j] ^= gfMul(gen[j + 1], factor);
			}
		}

		return rem;
	}

	/* ------------------------------------------------------------------ *
	 * Motifs d'alignement et informations de version / format.
	 * ------------------------------------------------------------------ */
	function alignmentPositions(version) {
		if (version === 1) {
			return [];
		}

		var count = Math.floor(version / 7) + 2,
			size = version * 4 + 17,
			step = (version === 32) ? 26 : Math.ceil((size - 13) / (2 * count - 2)) * 2,
			positions = [6],
			pos = size - 7;

		while (positions.length < count) {
			positions.splice(1, 0, pos);
			pos -= step;
		}

		positions.sort(function (a, b) { return a - b; });

		return positions;
	}

	function bchFormat(data) {
		var d = data << 10, i;

		for (i = 4; i >= 0; i--) {
			if (d & (1 << (i + 10))) {
				d ^= 0x537 << i;
			}
		}

		return ((data << 10) | d) ^ 0x5412;
	}

	function bchVersion(version) {
		var d = version << 12, i;

		for (i = 5; i >= 0; i--) {
			if (d & (1 << (i + 12))) {
				d ^= 0x1F25 << i;
			}
		}

		return (version << 12) | d;
	}

	var EC_BITS = { L: 1, M: 0, Q: 3, H: 2 };

	/* ------------------------------------------------------------------ *
	 * Construction de la matrice.
	 * ------------------------------------------------------------------ */
	function buildMatrix(version, level, codewords, mask, evaluating) {
		var size = version * 4 + 17,
			modules = [],
			reserved = [],
			r, c, i, j;

		for (r = 0; r < size; r++) {
			modules.push(new Array(size).fill(0));
			reserved.push(new Array(size).fill(false));
		}

		function place(row, col, value) {
			modules[row][col] = value ? 1 : 0;
			reserved[row][col] = true;
		}

		// Motifs de detection de position, aux trois coins.
		function finder(row, col) {
			for (r = -1; r <= 7; r++) {
				for (c = -1; c <= 7; c++) {
					if (row + r < 0 || row + r >= size || col + c < 0 || col + c >= size) {
						continue;
					}

					var on = (r >= 0 && r <= 6 && (c === 0 || c === 6)) ||
						(c >= 0 && c <= 6 && (r === 0 || r === 6)) ||
						(r >= 2 && r <= 4 && c >= 2 && c <= 4);

					place(row + r, col + c, on);
				}
			}
		}

		finder(0, 0);
		finder(0, size - 7);
		finder(size - 7, 0);

		// Motifs de synchronisation.
		for (i = 8; i < size - 8; i++) {
			place(6, i, i % 2 === 0);
			place(i, 6, i % 2 === 0);
		}

		// Motifs d'alignement.
		var pos = alignmentPositions(version);

		var last = pos.length - 1;

		for (i = 0; i < pos.length; i++) {
			for (j = 0; j < pos.length; j++) {
				var ar = pos[i], ac = pos[j];

				// Seuls les trois coins occupes par les reperes de position
				// sont exclus. Les alignements poses sur les lignes de
				// synchronisation, eux, doivent bien etre traces.
				if ((i === 0 && j === 0) ||
					(i === 0 && j === last) ||
					(i === last && j === 0)) {
					continue;
				}

				for (r = -2; r <= 2; r++) {
					for (c = -2; c <= 2; c++) {
						place(ar + r, ac + c,
							Math.max(Math.abs(r), Math.abs(c)) !== 1);
					}
				}
			}
		}

		// Module toujours noir.
		place(size - 8, 8, true);

		// Reservation des zones d'information de format.
		for (i = 0; i < 9; i++) {
			if (!reserved[8][i]) { reserved[8][i] = true; }
			if (!reserved[i][8]) { reserved[i][8] = true; }
		}

		for (i = 0; i < 8; i++) {
			reserved[8][size - 1 - i] = true;
			reserved[size - 1 - i][8] = true;
		}

		// Information de version, a partir de la version 7.
		if (version >= 7) {
			var vbits = bchVersion(version);

			for (i = 0; i < 18; i++) {
				// Neutralisee elle aussi pendant la comparaison des masques.
				var bit = !evaluating && ((vbits >> i) & 1) === 1;
				place(Math.floor(i / 3), size - 11 + (i % 3), bit);
				place(size - 11 + (i % 3), Math.floor(i / 3), bit);
			}
		}

		// Placement des donnees en zigzag, de bas en haut puis alterne.
		var bitIndex = 0,
			total = codewords.length * 8,
			upward = true,
			col;

		for (col = size - 1; col > 0; col -= 2) {
			if (col === 6) {
				col--; // La colonne de synchronisation est sautee.
			}

			for (i = 0; i < size; i++) {
				var row = upward ? (size - 1 - i) : i, k;

				for (k = 0; k < 2; k++) {
					var cc = col - k;

					if (reserved[row][cc]) {
						continue;
					}

					var dark = 0;

					if (bitIndex < total) {
						dark = (codewords[bitIndex >>> 3] >>> (7 - (bitIndex & 7))) & 1;
						bitIndex++;
					}

					if (maskCondition(mask, row, cc)) {
						dark ^= 1;
					}

					modules[row][cc] = dark;
				}
			}

			upward = !upward;
		}

		// Information de format, apres application du masque.
		var fbits = bchFormat((EC_BITS[level] << 3) | mask);

		for (i = 0; i < 15; i++) {
			// Pendant la comparaison des masques, ces zones sont laissees
			// claires : le score ne doit dependre que des donnees masquees.
			var b = evaluating ? 0 : ((fbits >> i) & 1);

			// Copie principale, autour du coin superieur gauche.
			if (i < 6) {
				modules[i][8] = b;
			} else if (i < 8) {
				modules[i + 1][8] = b;
			} else if (i < 9) {
				modules[8][7] = b;
			} else {
				modules[8][14 - i] = b;
			}

			// Copie de secours.
			if (i < 8) {
				modules[8][size - 1 - i] = b;
			} else {
				modules[size - 15 + i][8] = b;
			}
		}

		return modules;
	}

	function maskCondition(mask, row, col) {
		switch (mask) {
			case 0: return (row + col) % 2 === 0;
			case 1: return row % 2 === 0;
			case 2: return col % 3 === 0;
			case 3: return (row + col) % 3 === 0;
			case 4: return (Math.floor(row / 2) + Math.floor(col / 3)) % 2 === 0;
			case 5: return ((row * col) % 2) + ((row * col) % 3) === 0;
			case 6: return (((row * col) % 2) + ((row * col) % 3)) % 2 === 0;
			case 7: return (((row + col) % 2) + ((row * col) % 3)) % 2 === 0;
			default: return false;
		}
	}

	/* ------------------------------------------------------------------ *
	 * Evaluation des penalites, pour choisir le meilleur masque.
	 * ------------------------------------------------------------------ */
	function penalty(m) {
		var size = m.length, score = 0, r, c, i;

		// Regle 1 : suites de cinq modules identiques ou plus.
		function runs(getter) {
			var total = 0, a, b2, run, prev;

			for (a = 0; a < size; a++) {
				run = 1;
				prev = getter(a, 0);

				for (b2 = 1; b2 < size; b2++) {
					var cur = getter(a, b2);

					if (cur === prev) {
						run++;
					} else {
						if (run >= 5) { total += run - 2; }
						run = 1;
						prev = cur;
					}
				}

				if (run >= 5) { total += run - 2; }
			}

			return total;
		}

		score += runs(function (a, b2) { return m[a][b2]; });
		score += runs(function (a, b2) { return m[b2][a]; });

		// Regle 2 : blocs 2x2 de meme couleur.
		for (r = 0; r < size - 1; r++) {
			for (c = 0; c < size - 1; c++) {
				var v = m[r][c];

				if (v === m[r][c + 1] && v === m[r + 1][c] && v === m[r + 1][c + 1]) {
					score += 3;
				}
			}
		}

		// Regle 3 : motifs ressemblant aux reperes de position.
		var p1 = [1, 0, 1, 1, 1, 0, 1, 0, 0, 0, 0],
			p2 = [0, 0, 0, 0, 1, 0, 1, 1, 1, 0, 1];

		function match(line, pattern, start) {
			for (var k = 0; k < 11; k++) {
				if (line[start + k] !== pattern[k]) { return false; }
			}
			return true;
		}

		/**
		 * Balayage d'une ligne. Apres un module sombre en fin de fenetre, on
		 * avance de deux positions : aucun motif ne peut commencer sur la
		 * suivante. Ce decalage evite de compter deux fois des occurrences
		 * qui se chevauchent.
		 */
		function scanLine(line) {
			var total = 0, k = 0;

			while (k + 11 <= size) {
				if (match(line, p1, k) || match(line, p2, k)) {
					total += 40;
				}

				k += line[k + 10] ? 2 : 1;
			}

			return total;
		}

		for (r = 0; r < size; r++) {
			var colArr = [];

			for (i = 0; i < size; i++) {
				colArr.push(m[i][r]);
			}

			score += scanLine(m[r]);
			score += scanLine(colArr);
		}

		// Regle 4 : desequilibre entre modules clairs et sombres.
		var dark = 0;

		for (r = 0; r < size; r++) {
			for (c = 0; c < size; c++) {
				dark += m[r][c];
			}
		}

		var ratio = (dark * 100) / (size * size);
		score += Math.floor(Math.abs(ratio - 50) / 5) * 10;

		return score;
	}

	/* ------------------------------------------------------------------ *
	 * Encodage complet.
	 * ------------------------------------------------------------------ */
	function toUtf8Bytes(str) {
		var out = [], i, code;

		for (i = 0; i < str.length; i++) {
			code = str.charCodeAt(i);

			if (code < 0x80) {
				out.push(code);
			} else if (code < 0x800) {
				out.push(0xC0 | (code >> 6), 0x80 | (code & 0x3F));
			} else if (code >= 0xD800 && code <= 0xDBFF && i + 1 < str.length) {
				// Paire de substitution : caractere hors du plan de base.
				var full = 0x10000 + ((code - 0xD800) << 10) + (str.charCodeAt(++i) - 0xDC00);
				out.push(0xF0 | (full >> 18), 0x80 | ((full >> 12) & 0x3F),
					0x80 | ((full >> 6) & 0x3F), 0x80 | (full & 0x3F));
			} else {
				out.push(0xE0 | (code >> 12), 0x80 | ((code >> 6) & 0x3F), 0x80 | (code & 0x3F));
			}
		}

		return out;
	}

	function chooseVersion(byteLength, level) {
		var table = RS_BLOCKS[level], v, capacity, lengthBits;

		for (v = 1; v <= 20; v++) {
			capacity = 0;

			table[v - 1].forEach(function (block) {
				capacity += block[1];
			});

			lengthBits = (v < 10) ? 8 : 16;

			// 4 bits de mode + bits de longueur + donnees.
			if (capacity * 8 >= 4 + lengthBits + byteLength * 8) {
				return v;
			}
		}

		throw new Error('Contenu trop long pour un QR code de version 20.');
	}

	function encode(text, level) {
		level = level || 'M';

		var bytes = toUtf8Bytes(text),
			version = chooseVersion(bytes.length, level),
			blocks = RS_BLOCKS[level][version - 1],
			lengthBits = (version < 10) ? 8 : 16,
			bits = [],
			i, j;

		function pushBits(value, count) {
			for (var k = count - 1; k >= 0; k--) {
				bits.push((value >> k) & 1);
			}
		}

		pushBits(4, 4); // Mode octet.
		pushBits(bytes.length, lengthBits);

		for (i = 0; i < bytes.length; i++) {
			pushBits(bytes[i], 8);
		}

		var dataCapacity = 0;

		blocks.forEach(function (b) { dataCapacity += b[1]; });

		// Terminateur, puis alignement sur un octet.
		var terminator = Math.min(4, dataCapacity * 8 - bits.length);

		pushBits(0, terminator);

		while (bits.length % 8 !== 0) {
			bits.push(0);
		}

		var data = [];

		for (i = 0; i < bits.length; i += 8) {
			var byteVal = 0;

			for (j = 0; j < 8; j++) {
				byteVal = (byteVal << 1) | bits[i + j];
			}

			data.push(byteVal);
		}

		// Octets de remplissage alternes, conformement a la norme.
		var pad = [0xEC, 0x11], p = 0;

		while (data.length < dataCapacity) {
			data.push(pad[p++ % 2]);
		}

		// Decoupage en blocs, puis calcul des codewords de correction.
		var dataBlocks = [], ecBlocks = [], offset = 0;

		blocks.forEach(function (b) {
			var dataCount = b[1],
				ecCount = b[0] - b[1],
				chunk = data.slice(offset, offset + dataCount);

			offset += dataCount;
			dataBlocks.push(chunk);
			ecBlocks.push(rsEncode(chunk, ecCount));
		});

		// Entrelacement des blocs.
		var result = [], maxData = 0, maxEc = 0;

		dataBlocks.forEach(function (b) { maxData = Math.max(maxData, b.length); });
		ecBlocks.forEach(function (b) { maxEc = Math.max(maxEc, b.length); });

		for (i = 0; i < maxData; i++) {
			for (j = 0; j < dataBlocks.length; j++) {
				if (i < dataBlocks[j].length) {
					result.push(dataBlocks[j][i]);
				}
			}
		}

		for (i = 0; i < maxEc; i++) {
			for (j = 0; j < ecBlocks.length; j++) {
				if (i < ecBlocks[j].length) {
					result.push(ecBlocks[j][i]);
				}
			}
		}

		// Selection du masque produisant la plus faible penalite.
		var bestMask = 0, bestScore = Infinity, mask;

		for (mask = 0; mask < 8; mask++) {
			var score = penalty(buildMatrix(version, level, result, mask, true));

			if (score < bestScore) {
				bestScore = score;
				bestMask = mask;
			}
		}

		return buildMatrix(version, level, result, bestMask, false);
	}

	/* ------------------------------------------------------------------ *
	 * Rendu dans un canvas.
	 * ------------------------------------------------------------------ */
	function render(container, text, options) {
		options = options || {};

		var level = options.level || 'M',
			quiet = (options.quiet === undefined) ? 4 : options.quiet,
			targetPx = options.size || 220,
			matrix, size, scale, canvas, ctx, r, c;

		// Toute la generation est protegee : un navigateur sans canvas, ou un
		// contenu trop long, ne doit pas interrompre le reste de la page. Le
		// repli textuel present dans le conteneur reste alors affiche.
		try {
			matrix = encode(text, level);

		size = matrix.length + quiet * 2;
		scale = Math.max(2, Math.floor(targetPx / size));

		canvas = document.createElement('canvas');
		canvas.width = canvas.height = size * scale;
		canvas.style.width = canvas.style.height = (size * scale) + 'px';
		canvas.setAttribute('role', 'img');

		if (options.alt) {
			canvas.setAttribute('aria-label', options.alt);
		}

		ctx = canvas.getContext('2d');
		ctx.fillStyle = options.light || '#ffffff';
		ctx.fillRect(0, 0, canvas.width, canvas.height);
		ctx.fillStyle = options.dark || '#000000';

		for (r = 0; r < matrix.length; r++) {
			for (c = 0; c < matrix.length; c++) {
				if (matrix[r][c]) {
					ctx.fillRect((c + quiet) * scale, (r + quiet) * scale, scale, scale);
				}
			}
		}

		// Le repli textuel n'a plus lieu d'etre une fois le QR dessine.
		container.innerHTML = '';
		container.appendChild(canvas);

		} catch (e) {
			return false;
		}

		return true;
	}

	window.InMemoriamQR = {
		encode: encode,
		render: render
	};

	/**
	 * Initialisation automatique.
	 *
	 * phpBB place les scripts d'extension en pied de page : un appel ecrit
	 * dans le corps de la page s'executerait avant ce fichier, alors que
	 * window.InMemoriamQR n'existe pas encore. L'initialisation est donc
	 * portee ici, declenchee quand le document est pret.
	 */
	function autoInit() {
		var boxes = document.querySelectorAll('[data-inmemorium-qr]'), i;

		for (i = 0; i < boxes.length; i++) {
			var box = boxes[i],
				done = render(box, box.getAttribute('data-inmemorium-qr'), {
					level: 'Q',
					size: parseInt(box.getAttribute('data-size'), 10) || 200,
					alt: box.getAttribute('data-alt') || ''
				});

			if (!done && box.parentNode) {
				box.parentNode.style.display = 'none';
			}
		}
	}

	if (typeof document !== 'undefined') {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', autoInit);
		} else {
			autoInit();
		}
	}

	// Export pour les tests hors navigateur.
	if (typeof module !== 'undefined' && module.exports) {
		module.exports = window.InMemoriamQR;
	}

}(typeof window !== 'undefined' ? window : this));
